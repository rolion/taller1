<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of index
 *
 * @author root
 */


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

$this->title = 'Aplicar Examen';
$this->params['breadcrumbs'][] = ['label' => 'Mis Examenes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="area-form">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>

   
    <div class="form-group">
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
              'attribute'=>'id_examen',
               'value'=>function($model){
                        return $model->idExamen->nombre;
               }
            ],
            //'nombreExamen',
            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{aplicar}{corregir}',
                'buttons' => [
                'aplicar' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-open-file"></span>', $url, [
                                'title' => Yii::t('app', 'Aplicar'),
                            ]);
                    },
                'corregir'=>function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-stats"></span>', $url, [
                                'title' => Yii::t('app', 'Corregir'),
                            ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'aplicar') {
                        $url ='index.php?r=aplicar-examen/aplicar&id='.$model->id;//le pasamos el id de la inscripcion
                        return $url;
                    }
                    if($action=='corregir'){
                        $url ='index.php?r=aplicar-examen/sistema-experto&id='.$model->id;//le pasamos el id de la inscripcion
                        return $url;
                    }
                }
            ],
           
        ],
    ]); ?>
        
    </div>

    <?php ActiveForm::end(); ?>

</div>
