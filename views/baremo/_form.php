<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Area;
/* @var $this yii\web\View */
/* @var $model app\models\Baremo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="baremo-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'puntiacion_directa')->textInput() ?>

    <?= $form->field($model, 'percentil')->textInput() ?>

    <?= $form->field($model, 'id_area')->dropDownList(
            ArrayHelper::map(Area::findAll(['eliminado'=>'0']),'id','nombre'), 
    ['prompt'=>'seleccione el examen']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
