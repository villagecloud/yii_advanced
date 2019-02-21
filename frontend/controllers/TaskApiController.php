<?php

namespace frontend\controllers;

use common\models\Task;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class TaskApiController extends ActiveController
{
    public $modelClass = Task::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authentificator'] =[
            'class' => HttpBasicAuth::class,
            'auth' => function($username, $password){
                $user = User::findByUsername($username);
                if($user !== null && $user->validatePassword($password)){
                    return $user;
                }
                return null;
            }
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        $month = \Yii::$app->request->get('month');
        $responsible  = \Yii::$app->request->get('responsible');

        $filter = \Yii::$app->request->get('filter');
        //var_dump($month);exit;
        $query = Task::find();

        if($filter){
            $query->filterWhere($filter);
        }
        if($month){
            $query->FilterWhere([
                'MONTH(created_at)' => $month,
            ]);
        }
        if($responsible){
            $query->FilterWhere([
                'manager_id' => $responsible,
            ]);
        }

        return new ActiveDataProvider([
            'query' => $query
        ]);
    }

}

