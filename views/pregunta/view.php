<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\Pregunta */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Preguntas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pregunta-view">

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
           
            'descripcion_pregunta:ntext',
            ['attribute'=>'id_examen',
                'value'=>$model->idExamen->nombre,
            ],
            
            ['attribute'=>'id_area',
                'value'=>$model->idArea->nombre,
            ],
            [
                'attribute'=>'imagen',
                'value'=>$model->imagen,
                'format' => ['image',['width'=>'100','height'=>'100']],
            ],
        ],
    ]) ?>
    
    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
       'nombre_opcion',
        'descripcion_respuesta',
        'puntos_otorgados',
        [
        'attribute' => 'imagen',
        'format' => 'html',    
        'value' => function ($data) {
            return Html::img(Yii::getAlias('@web').'/'. $data['imagen'],
                ['width' => '70px']);
        },
    ]
       
        ]
    ])?>

</div>
