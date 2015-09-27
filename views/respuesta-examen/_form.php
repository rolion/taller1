<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RespuestaExamen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="respuesta-examen-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion_respuesta')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_pregunta')->textInput() ?>

    <?= $form->field($model, 'nombre_opcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imagen')->textInput() ?>

    <?= $form->field($model, 'puntos_otorgados')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
