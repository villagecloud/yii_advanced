<?php

namespace frontend\controllers;

use yii\db\Exception;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;
use Yii;
use common\models\Task;
use common\models\Tasks;
use yii\web\Controller;
use common\models\filters\TasksSearch;
use common\models\Comments;
use common\models\Users;
use common\models\TaskStatuses;
use common\models\forms\TaskAttachmentsAddForm;

class TaskController extends Controller
{
    public function actionIndex()
    {
        //echo '123'; exit;

/*        $dataProvider = new ActiveDataProvider([
            'query' => Tasks::find(),
            'pagination' => [
                'pageSize' => 5,
            ],

        ]);*/

        $searchModel = new TasksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

        //var_dump($dataProvider);
        //return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionView($id)
    {
        $model = Tasks::findOne($id);

        $newComment = new Comments();
        $newComment->task_id = $id;

        $comments = $model->getComments()->all();
        $uploaded_file = UploadedFile::getInstance($newComment,'attachment');

        if ($newComment->load(Yii::$app->request->post()) && $newComment->save()) {

                $newComment->attachment = $uploaded_file;
                $newComment->upload();

                if($newComment->attachment != null){
                    $newComment->attachment = $uploaded_file->name;
                    $newComment->update();
                }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('view', [
            'model' => $model,
            'comments' => $comments,
            'newComment' => $newComment,
        ]);
    }

    public function actionOne($id)
{
/*    if(!Yii::$app->user->can('TaskDelete'))
    {
        throw New ForbiddenHttpException();
    }*/

    return $this->render('one', [
        'model' => Tasks::findOne($id),
        'usersList' => Users::getUsersList(),
        'statusesList' => TaskStatuses::getList(),
        'userId' => Yii::$app->user->id,
        'taskCommentForm' => new Comments(),
        'taskAttachmentForm' => new TaskAttachmentsAddForm(),

    ]);
}

    public function actionSave($id)
    {
        if($model = Tasks::findOne($id)){
            $model->load(\Yii::$app->request->post());
            $model->save();
            \Yii::$app->session->setFlash('success', "Изменеия сохранены");
        }else {
            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения");
        }
        $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionAddComment()
    {
        //TODO: NEED to add permission to user
       /* if(!Yii::$app->user->can('CommentCreate')){
            throw new ForbiddenHttpException();
        }*/
        $model = new Comments();
        if($model->load(\Yii::$app->request->post()) && $model->save()){
            \Yii::$app->session->setFlash('success', "Комментарий добавлен");
        }else {
            \Yii::$app->session->setFlash('error', "Не удалось добавить комментарий");
        }
        $this->redirect(\Yii::$app->request->referrer);

    }

    public function actionAddAttachment()
    {
        //TODO: NEED to add permission to user
        /*if(!Yii::$app->user->can('AttachmentCreate')){
            throw new ForbiddenHttpException();
        }*/
        $model = new TaskAttachmentsAddForm();
        $model->load(\Yii::$app->request->post());
        $model->file = UploadedFile::getInstance($model, 'file');
        if($model->save()){
            \Yii::$app->session->setFlash('success', "Файл добавлен");
        }else {
            \Yii::$app->session->setFlash('error', "Не удалось добавить файл");
        }
        $this->redirect(\Yii::$app->request->referrer);



    }


    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['one', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }

}