<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\datecontrol\DateControl;
use app\models\Persona;
use app\models\InscripcionExamen;

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
        <?= Html::a('Update', ['update', 'id' => $persona->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $persona->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $persona,
        'attributes' => [
            'nombre',
            'apellido',
            'telefono',
            'ci',[
                'attribute'=>'id_colegio',
                'value'=>$persona->idColegio->nombre
            ],
            [
                'attribute'=>'id_tipo',
                'value'=>$persona->idTipo->nombre
            ],
        ],
    ]) ?>
     <?php foreach ($examenes as $i => $examen): ?>
     <?= DetailView::widget([
        'model' => $examen,
        'attributes' => [
            ['attribute'=>'id_examen',
                'value'=>$examen->idExamen->nombre],
            [
                'attribute'=>'fecha_inscripcion',
                'value'=>Yii::$app->formatter->asDatetime($examen->fecha_inscripcion),
            ],

        'fecha_aplicacion',
        ],
    ]) ?>
      <?php endforeach; ?>

</div>
