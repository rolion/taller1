<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

$this->title = 'Resultados Examen';
$this->params['breadcrumbs'][] = ['label' => 'Mis Examenes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Perfil: <?=$perfil?></h1>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'id_area',
                'value'=>function($model){
                        return $model->idArea->nombre;
                },
            ],
            [
                'attribute'=>'id_tipo',
                'value'=>function($model){
                        return $model->idTipo->nombre;
                },
            ],
            'nota',
        ],
    ]); ?>
