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

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\RespuestaExamen;
use app\models\Examen;
use app\models\RespuestaAlumno;
use app\models\Pregunta;
use yii\grid\GridView;

$this->title = 'Aplicar Examen';
$this->params['breadcrumbs'][] = ['label' => 'Mis Examenes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="area-form">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>

   
    <div class="form-group">
       <?php foreach($examenes as $i=> $examen):?>
            <?= Html::a("{$examen->nombre}", ['aplicar-examen/aplicar','id'=>$examen->id],
                    ['class'=>'btn btn-primary']) ?>
       <?php endforeach; ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombreExamen',
            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{aplicar}',
                'buttons' => [
                'aplicar' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                'title' => Yii::t('app', 'Aplicar'),
                            ]);
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'aplicar') {
                    $url ='index.php?r=aplicar-examen/aplicar&id='.$model->id_examen;
                    return $url;
                }
                }
            ],
        ],
    ]); ?>
        
    </div>

    <?php ActiveForm::end(); ?>

</div>
