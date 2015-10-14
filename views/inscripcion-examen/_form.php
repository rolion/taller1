<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Examen;
use app\models\Colegio;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use app\assets\AppAsset;
use yii\web\VIEW;

/* @var $this yii\web\View */
/* @var $model app\models\InscripcionExamen */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="inscripcion-examen-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form','options'=>['enctype'=>'multipart/form-data']]); ?>
 
    <?= $form->field($modelPersona, 'nombre')->textInput() ?>
    
    <?= $form->field($modelPersona, 'apellido')->textInput() ?>
    
    <?= $form->field($modelPersona, 'ci')->textInput(['id'=>'myId','container'=>'myId'])
           ?>
    <?= $form->field($modelPersona, 'telefono')->textInput() ?>
    
    <?= $form->field($modelPersona, 'ciudad')->dropDownList(array('Santa Cruz','La Paz','Cochabamba'
        ,'Beni','Pando','Oruro','Tarija','Chuquisaca')) ?>

    <?= $form->field($modelPersona, 'id_colegio')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Colegio::find()->all(), 'id', 'nombre'),
        'language' => 'en',
        'options' => ['placeholder' => 'Colegio ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
        //'pluginLoading'=>false,
    ])?>
    <?= $form->field($modelPersona, 'id_tipo')->dropDownList(
            ArrayHelper::map(app\models\TipoPersona::find()->all(), 'id', 'nombre'),
            ['prompt'=>'Seleccione un Tipo'])
            ?>
    
    
    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="row">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-bitcoin"></i> Inscripcion</h4></div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 2, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsInscripcion[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'id_examen',
                    'costo'
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelsInscripcion as $i => $modelsInscripcion): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Examenes</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelsInscripcion->isNewRecord) {
                                echo Html::activeHiddenInput($modelsInscripcion, "[{$i}]id");
                            }
                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                 <?=$form->field($modelsInscripcion, "[{$i}]id_examen")->dropDownList(
                                    ArrayHelper::map(Examen::find()->all(), 'id', 'nombre'), ['prompt' => 'seleccione el examen'])
                                    ?>
                                
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelsInscripcion, "[{$i}]costo")->textInput() ?>
                            </div>
                            
                        </div><!-- .row --> 
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton($modelPersona->isNewRecord ? 'Create' : 'Update', ['class' => $modelPersona->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php 
//AppAsset::register($this);
//$this->registerJs('pruebajs.js',VIEW::POS_READY);
?>
   
