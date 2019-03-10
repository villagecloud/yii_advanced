<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

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
 * @property int $project_id
 * @property int $closed_date
 *
 * @property Comments[] $comments
 * @property TaskAttachments[] $taskAttachments
 * @property User $manager
 * @property Project $project
 * @property TaskStatuses $status0
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['due_date', 'created_at', 'updated_at', 'closed_date'], 'safe'],
            [['manager_id'], 'required'],
            [['manager_id', 'status', 'project_id'], 'integer'],
            [['title', 'category', 'description', 'creation_date', 'attachment'], 'string', 'max' => 255],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['manager_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => TaskStatuses::className(), 'targetAttribute' => ['status' => 'id']],
        ];
    }

    public function myRule($attribute, $params)
    {
        if($this->$attribute == 'test' || strlen($this->$attribute) < 4){
            $this->addError($attribute, "Name cannot be *Test* or less than 4 symbols");
        }
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
            'created_at' => 'Created date',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'project_id' => 'Project ID',
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
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(TaskStatuses::className(), ['id' => 'status']);
    }

    public function setClosedDate(){
        return $this->closed_date = date("Y-m-d H:i:s");
    }

    public function checkDueDate($dueDate)
    {
        $now = date("Y-m-d");
        if($dueDate < $now)
        {
            return 'color: red';
        }
    }

}
