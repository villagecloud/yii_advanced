<?php

namespace common\models;

use yii\imagine\Image;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property int $task_id
 * @property string $comment
 * @property UploadedFile $attachment
 * @property Tasks $task
 * @property Users $user
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id'], 'required'],
            [['task_id'], 'integer'],
            [['user_id'], 'integer'],
            [['comment'], 'required'],
            [['attachment'], 'file', 'extensions' =>  'png, jpg'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'comment' => 'Comments',
            'attachment' => 'Attachment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }

    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }


    public function upload()
    {
        if($this->validate() && $this->attachment != null){
            //var_dump($this->attachment);exit;
            $filename = $this->attachment->getBaseName() . "." . $this->attachment->getExtension();
            $filepath = Yii::getAlias("@img/{$filename}");
            $this->attachment->saveAs($filepath);

            Image::thumbnail($filepath, 100, 100)
                ->save(Yii::getAlias("@img/small/{$filename}"));
        }
        //var_dump($filename);
    }


}
