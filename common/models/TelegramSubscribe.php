<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "telegram_subscribe".
 *
 * @property int $id
 * @property int $chat_id
 * @property string $channel
 */
class TelegramSubscribe extends \yii\db\ActiveRecord
{
    const CHANNEL_PROJECT_CREATE  = 'projects_create';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_subscribe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chat_id'], 'integer'],
            [['channel'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chat_id' => 'Chat ID',
            'channel' => 'Channel',
        ];
    }
}
