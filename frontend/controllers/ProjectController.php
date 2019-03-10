<?php


namespace frontend\controllers;


use common\models\Project;
use common\models\Task;
use yii\web\Controller;
use Yii;

class ProjectController extends Controller
{
    public function actionIndex()
    {
        $model = Project::find()->all();

        return $this->render('index', [
            'model' => $model,
        ]);
    }


    public function actionCreate()
    {
        $model = new Project();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //echo 'saved'; exit;
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }

    public function actionCreteTask()
    {

    }


}