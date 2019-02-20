<?php

namespace common\components;


use common\models\Project;
use common\models\TelegramSubscribe;
use yii\base\Component;
use yii\base\Event;

class BootstrapComponent extends Component
{
    public function init(){
        Event::on(Project::class, Project::EVENT_AFTER_INSERT, function(Event $event){

            $title = $event->sender->title;
            $message = "Создан новый проект {$title}";

            $subscribers = TelegramSubscribe::find()
                ->select('chat_id')
                ->where(['channel' => TelegramSubscribe::CHANNEL_PROJECT_CREATE])
                ->column();
            foreach ($subscribers as $subscriber){
                /** @var \SonkoDmitry\Yii\TelegramBot\Component $bot */
                $bot = \Yii::$app->bot;
                $bot->sendMessage($subscriber, $message);
            }
        });
    }
}