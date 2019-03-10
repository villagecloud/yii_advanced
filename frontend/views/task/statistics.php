<?php
use yii\helpers\Html;

$closedTasks = $closed->getModels();
$breachedTasks = $breached->getModels();

?>

<div class="row">
    <div class="col-sm-4">
        <h3>All tasks (<?= count($all)?>)</h3>
        <div class="list-group">
            <?php foreach ($all as $task):?>
                <?=Html::a($task->title , ['task/one', 'id' => $task->id ], ['class' => 'list-group-item list-group-item-action'])?>
            <?php endforeach;?>
        </div>
    </div>
    <div class="col-sm-4">
        <h3>Closed tasks (<?= count($closedTasks)?>)</h3>
        <div class="list-group">
            <?php foreach ($closedTasks as $task):?>
                <?=Html::a($task->title , ['task/one', 'id' => $task->id ], ['class' => 'list-group-item list-group-item-action'])?>
            <?php endforeach;?>
        </div>
    </div>
    <div class="col-sm-4">
        <h3>Breached tasks (<?= count($breachedTasks)?>)</h3>
        <div class="list-group">
            <?php foreach ($breachedTasks as $task):?>
                <?=Html::a($task->title , ['task/one', 'id' => $task->id ], ['class' => 'list-group-item list-group-item-action'])?>
            <?php endforeach;?>
        </div>
    </div>

</div>
