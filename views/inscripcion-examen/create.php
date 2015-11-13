<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\InscripcionExamen */

$this->title = 'Create Inscripcion Examen';
$this->params['breadcrumbs'][] = ['label' => 'Inscripcion Examens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inscripcion-examen-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelPersona' => $modelPersona,
        'modelsInscripcion'=>$modelsInscripcion,
    ]) ?>

</div>
