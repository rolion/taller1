<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InscripcionExamenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inscripcion Examens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inscripcion-examen-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Inscripcion Examen', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_alumno',
            'id_examen',
            'fecha_inscripcion',
            'fecha_aplicacion',
            // 'eliminado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
