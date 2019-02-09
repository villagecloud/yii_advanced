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
            <?=Html::submitButton("Добавить",['class' => 'btn btn-default', 'value' => 'add_attachment']);?>
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


    <form action="#" name="chat_form" id="chat_form">
        <label>
            введите сообщение
            <input type="text" name="message"/>
            <input type="submit"/>
        </label>
    </form>
    <hr>
    <div id="root_chat"></div>
    <script>
        if (!window.WebSocket){
            alert("Ваш браузер неподдерживает веб-сокеты!");
        }

        var webSocket = new WebSocket("ws://front.yii2:8080?task_chat=<?php echo $model->id ?>");



/*        var url = 'http://front.yii2:8888/index.php?r=task%2Fone&id=5';
        var id = url.substring(url.lastIndexOf('&id=') + 1);*/
        var task_id = '<?php echo $model->id ?>';
        var room_id = '<?php echo $model->id ?>';

        //alert(id);

        document.getElementById("chat_form")
            .addEventListener('submit', function(event){
                var textMessage = this.message.value;
                var msg =  {
                    "task_id" : task_id,
                    "room_id" : room_id,
                    "message" : textMessage
                };
                webSocket.send(JSON.stringify(msg));


                //webSocket.send(task_id);
                event.preventDefault();
                return false;
            });

        webSocket.onmessage = function (event) {
            var data = event.data;
            var messageContainer = document.createElement('div');
            var textNode = document.createTextNode(data);
            messageContainer.appendChild(textNode);
            document.getElementById("root_chat")
                .appendChild(messageContainer);
        };
    </script>

</div>