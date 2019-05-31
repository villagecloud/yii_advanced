<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\filters\TasksSearch */
/* @var $form yii\widgets\ActiveForm */

?>

<?php //var_dump($dataProvider->getModels());?>
    <p style="padding: 20px"><?=Html::a('New Task', ['task/create'], ['class' => 'btn btn-primary'])?></p>

    <div class="tasks-search">

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>

        <?= $form->field($searchModel, 'created_at')->label('Сортировать по месяцу')->dropDownList([
            '' => 'покать все задачи',
            1 => 'январь',
            2 => 'февраль',
            3 => 'март',
            4 => 'апрель',
            5 => 'май',
            6 => 'июнь',
            7 => 'июль',
            8 => 'август',
            9 => 'сентябрь',
            10 => 'октябрь',
            11 => 'ноябрь',
            12 => 'декабрь',
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

<?php echo \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => function($model){
                    //var_dump($model);
                    return \common\widgets\TaskWidget::widget(['model' => $model]);
                },
                'summary' => false,
            ]);



?>