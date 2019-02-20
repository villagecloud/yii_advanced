<?php

use yii\db\Migration;

/**
 * Handles the creation of table `telegram_subscribe`.
 */
class m181206_170902_create_telegram_subscribe_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('telegram_subscribe', [
            'id' => $this->primaryKey(),
            'chat_id' => $this->integer(),
            'channel' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('telegram_subscribe');
    }
}
