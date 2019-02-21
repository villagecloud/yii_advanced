<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 20/02/19
 * Time: 17:45
 */

namespace frontend\controllers;


use SonkoDmitry\Yii\TelegramBot\Component;
use yii\web\Controller;

class TelegramController extends Controller
{
    public function actionReceive(){

        /** @var Component $bot */
        $bot = \Yii::$app->bot;
        $bot->setCurlOption(CURLOPT_TIMEOUT, 20);
        $bot->setCurlOption(CURLOPT_CONNECTTIMEOUT, 10);
        $bot->setCurlOption(CURLOPT_HTTPHEADER, ['Expect:']);

        $updates = $bot->getUpdates();

        $messages = [];
        foreach ($updates as $update){
            $message = $update->getMessage();
            $username = $message->getFrom()->getFirstName() . " " . $message->getFrom()->getLastName();

            $messages[] = [
                'text' => $message->getText(),
                'username' => $username,
            ];
        }

        return $this->render('receive', ['messages' => $messages]);

    }

    public function actionSend()
    {
        /** @var Component $bot */
        $bot = \Yii::$app->bot;
        $bot->sendMessage(422843838, 'Тестовое сообщение');
    }
}