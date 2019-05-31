<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $form yii\widgets\ActiveForm */
/* @var $this yii\web\View */
/* @var $newComment \app\models\Comments*/
?>



<h3><?= $model->title?></h3>
<p><?= $model->description?></p>

<div class="panel panel-default">
    <div class="panel-heading">Comments:</div>
    <ul class="list-group">
        <?php

        foreach ($comments as $comment){
            //var_dump($comment->comment, $comment->attachment);

            if($comment->attachment == null){
                echo "<li class='list-group-item'> $comment->comment</li>";
            }else{
                echo "<li class='list-group-item'> $comment->comment  <a target='_blank' href='/img/$comment->attachment'><img src='/img/small/$comment->attachment'/></a></li>";
            }
        }
        ?>

    </ul>
</div>

<div class="tasks-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($newComment, 'comment')->textInput(['maxlength' => true]) ?>
    <?= $form->field($newComment, 'attachment')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php //$newComment->save()?>

</div>

