<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Area;
/* @var $this yii\web\View */
/* @var $model app\models\Carrera */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="carrera-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'id_area')->dropDownList(
            ArrayHelper::map(Area::find()->all(),'id', 'nombre'),
            ['prompt'=>'Seleccione el area']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
