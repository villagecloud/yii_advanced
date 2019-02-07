<?php

namespace common\widgets;


use common\models\Tasks;
use yii\base\Widget;

class TaskWidget extends Widget
{
    public $model;

    public function run()
    {
        //$model = Tasks::find()->select('id, title, description')->asArray()->all();
        //return $this->render('taskList', ['model' => $model]);
        return $this->render('taskList', ['model' => $this->model]);
    }
}