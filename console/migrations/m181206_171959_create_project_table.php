<?php

use yii\db\Migration;

/**
 * Handles the creation of table `project`.
 */
class m181206_171959_create_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('project', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->string()
        ]);

        $this->addColumn('tasks', 'project_id', $this->integer());

        $this->addForeignKey(
            'fk_projects_tasks',
            'tasks',
            'project_id',
            'project',
            'id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('project');
    }
}
