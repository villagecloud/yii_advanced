<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comments`.
 */
class m190118_140853_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comments', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer()->notNull(),
            'comment' => $this->string(),
            'attachment' => $this->string(),
        ]);

        $this->addForeignKey(
            'fk-tasks_id',
            'comments',
            'task_id',
            'tasks',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('comments');
    }
}
