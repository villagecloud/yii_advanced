<?php

use yii\db\Migration;

/**
 * Handles the creation of table `statuses`.
 */
class m190123_100029_create_statuses_table extends Migration
{
    protected $tableName = 'task_statuses';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)
        ]);

        $this->batchInsert($this->tableName, ['name'], [
            ['Новая'],
            ['В работе'],
            ['Выполнена'],
            ['Тестирование'],
            ['Доработка'],
            ['Закрыта'],
        ]);

        $taskTable = 'tasks';

        $this->addColumn($taskTable,'status', 'INT');

        $this->addForeignKey(
            'fk_task_statuses',
            $taskTable,
            'status',
            $this->tableName,
            'id');
        $this->update($taskTable, ['status' => 1]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('statuses');
    }
}
