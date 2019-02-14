<?php

use yii\db\Migration;

/**
 * Handles adding datetime to table `tasks`.
 */
class m190114_115649_add_datetime_columns_to_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tasks', 'created_at', $this->dateTime());
        $this->addColumn('tasks', 'updated_at', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('tasks', 'created_at');
        $this->dropColumn('tasks', 'updated_at');
    }
}
