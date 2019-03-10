<?php

use yii\helpers\Html;

//var_dump($model);
/** @var \common\models\Project $project*/
//var_dump($model);
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Library</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
    </ol>
</nav>

    <p style="margin-bottom: 50px"><?=Html::a('New project', ['project/create'], ['class' => 'btn btn-success'])?></p>
    <?php foreach ($model as $project):?>
    <h2><?= $project->title . ' - ' . $project->description ?></h2>
    <div class="panel panel-default" style="margin-bottom: 40px">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <p><?=Html::a(
                    'Create new task for project', ['task/create'],
                        [
                            'class' => 'btn btn-default',
                            'data' => [
                                'method' => 'POST',
                                'params' => ['projectId' => $project->id],
                            ]
                        ])
                ?></p>
        </div>
        <div class="panel-body">
            <p> <b>List of the tasks for this project:</b> </p>
        </div>

        <!-- List group -->
        <ul class="list-group">
        <?php foreach ($project->tasks as $task):?>
            <li class="list-group-item"><?= Html::a( $task->title, ['task/one','id' => $task->id ]) . ' - ' . $task->manager['username'] ?></li>
        <?php endforeach; ?>
            <?php //var_dump($project->tasks)?>

        </ul>
    </div>
    <?php endforeach; ?>
