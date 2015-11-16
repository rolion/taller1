<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Examen;

$this->title = 'Registrar Llave';
//$this->params['breadcrumbs'][] = ['label' => 'Inscripcion Examens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inscripcion-examen-form">
    <?php $form = ActiveForm::begin(); ?>
        <?=$form->field($model, "id_examen")->dropDownList(
            ArrayHelper::map(Examen::find()->all(), 'id', 'nombre'), ['prompt' => 'seleccione el examen'])
              ?>
        <?= $form->field($model,'llave')->textInput()?>
    <div class="form-group">
        <?= Html::submitButton( 'Registrar', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

