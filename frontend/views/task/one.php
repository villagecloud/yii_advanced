<?php
/**@var \app\models\Tasks $model */
/**@var integer $userId */
/**@var \app\models\TaskStatuses[] $statusesList */
/**@var \app\models\Users[] $usersList */
/**@var \app\models\Comments $taskCommentForm */
/**@var \app\models\TaskAttachments $taskAttachmentForm */
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

?>

<div class="tasks-edit">
    <div class="task-main">
        <?php $form = ActiveForm::begin(['action' => Url::to(['task/save', 'id' => $model->id])]);?>
        <?=$form->field($model, 'title')->textInput();?>
        <div class="row">
            <div class="col-lg-4">
                <?=$form->field($model, 'status')
                    ->dropDownList($statusesList)?>
            </div>
            <div class="col-lg-4">
                <?=$form->field($model, 'manager_id')
                    ->dropDownList($usersList)?>
            </div>
            <div class="col-lg-4">
                <?=$form->field($model, 'due_date')
                    ->textInput(['type' => 'date'])?>
            </div>
        </div>
        <div>
            <?=$form->field($model, 'description')
                ->textarea()?>
        </div>
        <?=Html::submitButton("Сохранить",['class' => 'btn btn-success']);?>
        <?php ActiveForm::end();?>
    </div>
</div>

<div class="attachments">
    <h3>Вложения</h3>
    <?php $form = ActiveForm::begin([
        'action' => Url::to(['task/add-attachment']),
        'options' => ['class' => "form-inline"]
    ]);?>
    <?=$form->field($taskAttachmentForm, 'taskId')->hiddenInput(['value' => $model->id])->label(false);?>
    <?=$form->field($taskAttachmentForm, 'file')->fileInput();?>
    <?=Html::submitButton("Добавить",['class' => 'btn btn-default']);?>
    <?php ActiveForm::end();?>
    <hr>

    <div class="attachments-history">
        <?php foreach ($model->taskAttachments as $file): ?>
            <a href="/img/tasks/<?=$file->path?>">
                <img src="/img/tasks/small/<?=$file->path?>" alt="">
            </a>
        <?php endforeach;?>
    </div>

    <div class="task-history">
        <div class="comments">
            <h3>Комментарии</h3>
            <?php $form = ActiveForm::begin(['action' => Url::to(['task/add-comment'])]);?>
            <?=$form->field($taskCommentForm, 'user_id')->hiddenInput(['value' => $userId])->label(false);?>
            <?=$form->field($taskCommentForm, 'task_id')->hiddenInput(['value' => $model->id])->label(false);?>
            <?=$form->field($taskCommentForm, 'comment')->textInput();?>
            <?=Html::submitButton("Добавить",['class' => 'btn btn-default']);?>
            <?php ActiveForm::end();?>
            <hr>
            <div class="comment-history">
                <?php //var_dump($model->comments); exit; ?>
                <?php foreach ($model->comments as $comment): ?>
                    <p><strong><?php echo $comment->user['username'] ?></strong>: <?=$comment->comment?></p>
                <?php endforeach;?>
            </div>
        </div>

    </div>
</div>