<?php
use yii\helpers\Html;
use app\widgets\TaskWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

?>
    <div class="col-sm-3 col-md-4">
        <div class="thumbnail">
            <div class="caption">
                <h3><?= $model->title?></h3>
                <p><?= $model->description?></p>
                <p><?=Html::a('View', ['task/one', 'id' => $model->id], ['class' => 'btn btn-primary'])?></p>
                <p><?=Html::a('Update', ['task/update', 'id' => $model->id], ['class' => 'btn btn-primary'])?></p>
            </div>
        </div>
    </div>

