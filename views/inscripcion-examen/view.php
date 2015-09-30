<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\models\InscripcionExamen */

//$this->title = $model->id;
$this->title ='Inscripcion';
$this->params['breadcrumbs'][] = ['label' => 'Inscripcion Examens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inscripcion-examen-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            ['attribute'=>'id_alumno',
                'value'=>$model->idAlumno->nombre.' '.$model->idAlumno->apellido],
            ['attribute'=>'id_examen',
                'value'=>$model->idExamen->nombre],
            [
                'attribute'=>'fecha_inscripcion',
                'format'=>['date', 'd-m-Y'],
               // 'value'=>$model->fecha_inscripcion,
                //'type'=>DetailView::INPUT_WIDGET, // setup custom widget
                'widgetOptions'=>[
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATE
                    ]
            ],

        'fecha_aplicacion',
        ],
    ]) ?>

</div>
