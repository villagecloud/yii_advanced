<?php

namespace common\models;

use app\components\controllerEvents\TaskEvent;
use app\components\validators\CustomValidator;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * Class Task
 * @property string $title
 * @property string $status
 */
class Task extends ActiveRecord
{

    public static function tableName()
    {
        return 'tasks';
    }

    public function rules()
    {
        return [
            [['manager_id'], 'required'],
            [['manager_id'], 'integer'],
            [['status', 'due_date'], 'safe'],
            [['title', 'category', 'description', 'creation_date', 'attachment'], 'string', 'max' => 255],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['manager_id' => 'id']],
        ];
    }

    public function myRule($attribute, $params)
    {
        if($this->$attribute == 'test' || strlen($this->$attribute) < 4){
            $this->addError($attribute, "Name cannot be *Test* or less than 4 symbols");
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        ];
    }

    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['task_id' => 'id']);
    }

}