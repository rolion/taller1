<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Baremos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="baremo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Baremo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'puntiacion_directa',
            'percentil',
            'id_area',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
