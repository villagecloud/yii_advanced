<?php

namespace backend\models;

use common\models\Comments;
use common\models\Task;
use common\models\TaskAttachments;
use common\models\TaskStatuses;
use common\models\User;
use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $title
 * @property string $category
 * @property string $description
 * @property string $creation_date
 * @property string $due_date
 * @property string $attachment
 * @property int $manager_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 *
 * @property Comments[] $comments
 * @property TaskAttachments[] $taskAttachments
 * @property User $manager
 * @property TaskStatuses $status0
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['manager_id'], 'required'],
            [['manager_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'category', 'description', 'creation_date', 'due_date', 'attachment'], 'string', 'max' => 255],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['manager_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => TaskStatuses::className(), 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'category' => 'Category',
            'description' => 'Description',
            'creation_date' => 'Creation Date',
            'due_date' => 'Due Date',
            'attachment' => 'Attachment',
            'manager_id' => 'Manager ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskAttachments()
    {
        return $this->hasMany(TaskAttachments::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(User::className(), ['id' => 'manager_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(TaskStatuses::className(), ['id' => 'status']);
    }
}
