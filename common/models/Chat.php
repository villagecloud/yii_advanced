<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property string $chat_channel
 * @property string $message
 * @property int $user_id
 * @property string $created_at
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['chat_channel', 'message'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chat_channel' => 'Chat Channel',
            'message' => 'Message',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }
}
