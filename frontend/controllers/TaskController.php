<?php

namespace frontend\controllers;

use common\models\Chat;
use yii\data\ActiveDataProvider;
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
        'model' => Task::findOne($id),
        'usersList' => Users::getUsersList(),
        'statusesList' => TaskStatuses::getList(),
        'userId' => Yii::$app->user->id,
        'taskCommentForm' => new Comments(),
        'taskAttachmentForm' => new TaskAttachmentsAddForm(),
        'chatHistory' => Chat::find()->limit(20)->where(['chat_channel' => $id])->all(),

    ]);
}

    public function actionSave($id)
    {
        if($model = Task::findOne($id)){
            $model->load(\Yii::$app->request->post());

            if(\Yii::$app->request->bodyParams['Task']['status'] == 6 && $model->closed_date == null)
            {
                $model->closed_date = $model->setClosedDate();
            }
            $model->save();
            \Yii::$app->session->setFlash('success', "Изменеия сохранены");


        }else {
            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения");
        }
        //$this->actionOne($id);
        $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionAddComment()
    {
        //TODO: NEED to add permission to user
        if(!Yii::$app->user->can('CommentCreate')){
            throw new ForbiddenHttpException();
        }

        $model = new Comments();
        if($model->load(\Yii::$app->request->post()) && $model->save()){
            \Yii::$app->session->setFlash('success', "Комментарий добавлен");
        }else {
            \Yii::$app->session->setFlash('error', "Не удалось добавить комментарий");
        }
        $this->actionOne($model->task_id);
        //$this->redirect(\Yii::$app->request->referrer);
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
        $projectId = \Yii::$app->request->post('projectId');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['one', 'id' => $model->id]);
        }

        return $this->render('create', [
        'model' => $model,
            'projectId' => $projectId,
    ]);

    }

    public function actionStats()
    {
        $searchModel = new TasksSearch();
        $closedTasks = $searchModel->search([$searchModel->formName()=>['status' => 6]]);

        $query = Tasks::find()->where('due_date < CURDATE()');
        $breachedTasks = new ActiveDataProvider([
            'query' => $query,
        ]);

        $allTasks = Tasks::find()->all();

        return $this->render('statistics', [
            'closed' => $closedTasks,
            'breached' => $breachedTasks,
            'all' => $allTasks,
        ]);
    }

}