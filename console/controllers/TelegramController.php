<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 20/02/19
 * Time: 18:52
 */

namespace console\controllers;


use common\models\Task;
use common\models\TelegramOffset;
use common\models\TelegramSubscribe;
use SonkoDmitry\Yii\TelegramBot\Component;
use TelegramBot\Api\Types\Message;
use TelegramBot\Api\Types\Update;
use yii\console\Controller;

class TelegramController extends Controller
{
    /** @var Component */
    private $bot;
    private $offset = 0;

    public function init()
    {
        parent::init();
        $this->bot = \Yii::$app->bot;
    }

    public function actionIndex()
    {
        $updates = $this->bot->getUpdates($this->getOffset() + 1);
        $updateCount = count($updates);
        if($updateCount > 0){
            foreach ($updates as $update){
                $this->updateOffset($update);
                if($message = $update->getMessage()){
                    $this->processCommand($message);
                }
            }

            echo "Новых сообщений: " . $updateCount . PHP_EOL;
        }else{
            echo "Новых сообщений нет" . PHP_EOL;
        }
    }

    private function getOffset()
    {
        $max = TelegramOffset::find()
            ->select('id')
            ->max('id');
        if($max > 0 ){
            $this->offset = $max;
        }
        return $this->offset;
    }

    private function updateOffset(Update $update)
    {
        $model = new TelegramOffset([
            'id' => $update->getUpdateId(),
            'timestamp_offset' => date("Y-m-d H:i:s")
        ]);
        $model->save();
    }

    private function processCommand(Message $message)
    {
        $params = explode(" ", $message->getText());
        $command = $params[0];
        var_dump($command);
        $response = "Unknown command";
        switch($command){
            case '/help':
                $response = "Доступные команды: \n";
                $response .= "/help - список комманд\n";
                $response .= "/project_create ##project_name## -создание нового проекта\n";
                $response .= "/task_create ##task_name## ##responcible## ##project## -создание таска\n";
                $response .= "/sp_create  - подписка на создание проекты\n";
                break;
            case "/sp_create":
                $model = new TelegramSubscribe([
                    'chat_id' => $message->getFrom()->getId(),
                    'channel' => TelegramSubscribe::CHANNEL_PROJECT_CREATE
                ]);
                if($model->save()){
                    $response = "Вы подписаны на оповещения об обновлении проектов";
                }else{
                    $response = "error";
                }
                break;
            case "/task_create":
                $model = new Task([
                    'manager_id' => 1,
                    'title' => 'Данный таск создан через телегу!'
                ]);
                if($model->save()){
                    $response = "Таск был успешно создан!";
                }else{
                    $response = "Возникла ошибка при создании таска!";
                }
                break;
        }

        $this->bot->sendMessage($message->getFrom()->getId(), $response);
    }


}