<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Examen;
use app\models\Area;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Pregunta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pregunta-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form','options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'nro_pregunta')->textInput() ?>
    <?= $form->field($model, 'descripcion_pregunta')->textarea(['rows' => 6]) ?>
    

    <?= $form->field($model, 'id_examen')->dropDownList(
            ArrayHelper::map(Examen::find()->where(['eliminado'=>0])->all(),'id','nombre'), 
    ['prompt'=>'seleccione el examen']) ?>

    <?= $form->field($model, 'file')->fileInput()?>

    <?= $form->field($model, 'id_area')->dropDownList(
    ArrayHelper::map(Area::find()->where(['eliminado'=>0])->all(), 'id', 'nombre'),
            ['prompt'=>'Seleccione el area']) ?>
    
    
    <div class="row">
           <div class="panel panel-default">
        <div class="panel-heading">
            <h4><i class="glyphicon glyphicon-question-sign"></i> Respuestas</h4></div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelRespuestaExamen[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'nombre_opcion',
                    'descripcion_respuesta',
                    'puntos_otorgados',
                    'imgfile'
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelRespuestaExamen as $i => $modelRespuestaExamen): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Respuesta</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelRespuestaExamen->isNewRecord) {
                                echo Html::activeHiddenInput($modelRespuestaExamen, "[{$i}]id");
                            }
                        ?>
                        <?= $form->field($modelRespuestaExamen, "[{$i}]nombre_opcion")->textInput(['maxlength' => true]) ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelRespuestaExamen, "[{$i}]descripcion_respuesta")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($modelRespuestaExamen, "[{$i}]puntos_otorgados")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-6">
                                <?=$form->field($modelRespuestaExamen, "[{$i}]imgfile")->fileInput()?>
                            </div>
                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>
        
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
