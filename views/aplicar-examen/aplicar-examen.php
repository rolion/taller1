<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\RespuestaExamen;
use app\models\Examen;
use app\models\RespuestaAlumno;
use app\models\Pregunta;

$this->title = $examen->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Mis Examenes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>


<div class="aplicar-examen-form">
    <h1><?= Html::encode($this->title) ?></h1>
        
    <?php $form = ActiveForm::begin(['id' => 'dynamic-form',
        'action'=>'index.php?r=aplicar-examen/guardar-respuesta']); ?>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 4, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $respuestasAlumno[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'id_respuesta'
        ],
    ]); ?>

    <div class="panel panel-default">
       
        <div class="panel-body">
            <div class="container-items"><!-- widgetBody -->
            <?php foreach ($preguntas as $i => $pregunta): ?>
                <div class="item panel panel-default"><!-- widgetItem -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left"><?=$pregunta->nro_pregunta."-". $pregunta->descripcion_pregunta?></h3>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        
                        <?=  $form->field($respuestasAlumno[$i], "[{$i}]id_respuesta")->radioList(
                            ArrayHelper::map( RespuestaExamen::
                               find()->where(['id_pregunta'=>$pregunta->id])->all(),
                                    'id', 'descripcion_respuesta'))->label(false); ?>
                        <!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div><!-- .panel -->
    <?php DynamicFormWidget::end(); ?>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
    


