<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task_attachments`.
 */
class m190123_131131_create_task_attachments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('comments', 'user_id', $this->integer());


        $taskTable = 'tasks';
        $userTable = 'user';

        $this->addForeignKey('fk_comments_users','comments', 'user_id', $userTable, 'id');

        $this->createTable('task_attachments', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer(),
            'path' => $this->string()
        ]);

        $this->addForeignKey('fk_attachments_tasks','task_attachments', 'task_id', $taskTable, 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('task_attachments');
    }
}
