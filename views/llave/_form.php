<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Colegio;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Llave */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="llave-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'id_colegio')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Colegio::find()->all(), 'id', 'nombre'),
        'language' => 'en',
        'options' => ['placeholder' => 'Colegio ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])?>



    <?= $form->field($model, 'cantidad')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Generar Llave' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
