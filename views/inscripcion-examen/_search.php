<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\InscripcionExamenSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inscripcion-examen-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_alumno') ?>

    <?= $form->field($model, 'id_examen') ?>

    <?= $form->field($model, 'fecha_inscripcion') ?>

    <?= $form->field($model, 'fecha_aplicacion') ?>

    <?php // echo $form->field($model, 'eliminado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
