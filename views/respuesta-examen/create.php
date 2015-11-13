<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RespuestaExamen */

$this->title = 'Create Respuesta Examen';
$this->params['breadcrumbs'][] = ['label' => 'Respuesta Examens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="respuesta-examen-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
