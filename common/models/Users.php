<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property string $access_token
 * @property int $role_id
 *
 * @property Tasks[] $tasks
 * @property Roles $role
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id'], 'integer'],
            [['username', 'password', 'auth_key', 'access_token'], 'string', 'max' => 255],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::class, 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'role_id' => 'Role ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['manager_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public
    function getRole()
    {
        return $this->hasOne(Roles::class, ['id' => 'role_id']);
    }

    public static function getUsersList(){
         $users = static::find()
            ->select(['id','username'])
            ->asArray()
            ->All();
        return ArrayHelper::map($users, 'id', 'username');
    }

    public static function getUserById($id){
        return static::findOne($id);
    }

}
