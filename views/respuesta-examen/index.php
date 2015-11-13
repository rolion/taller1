<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Respuesta Examens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="respuesta-examen-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Respuesta Examen', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'descripcion_respuesta:ntext',
            'id_pregunta',
            'nombre_opcion',
            'imagen',
            // 'puntos_otorgados',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
