<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Colegio;
/* @var $this yii\web\View */
/* @var $model app\models\Persona */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="persona-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellido')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ci')->textInput() ?>

    <?= $form->field($model, 'ciudad')->dropDownList(array('Santa Cruz','La Paz','Cochabamba'
        ,'Beni','Pando','Oruro','Tarija','Chuquisaca')) ?>
    
    <?= $form->field($model, 'id_colegio')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Colegio::find()->all(), 'id', 'nombre'),
        'language' => 'en',
        'options' => ['placeholder' => 'Colegio ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])?>

    <?= $form->field($model, 'nick')->textInput()?>
    <?= $form->field($model, 'pass')->passwordInput()?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
