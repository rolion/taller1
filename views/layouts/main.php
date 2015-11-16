<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Examenes Psicotecnicos',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    
    if(!Yii::$app->user->isGuest){
        if(Yii::$app->user->identity->idPersona->id_tipo==1){
             echo Nav::widget([ 
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'Mis Examenes', 'url' => ['/aplicar-examen/index']],
                    ['label' => 'inscripcion', 'url' => ['/inscripcion-examen/inscripcion-llave']],

                    Yii::$app->user->isGuest ?
                        ['label' => 'Login', 'url' => ['/site/login']] :
                        [
                            'label' => 'Logout (' . Yii::$app->user->identity->usuario . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']
                        ],
                ],
            ]);
        }else{
            echo Nav::widget([ 
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label'=>'Llaves','url'=>['/llave/index']],
                ['label' => 'Categoria Pregunta', 'url' => ['/area/create']],
                ['label' => 'Baremo', 'url' => ['/baremo/create']],
                ['label' => 'Colegio', 'url' => ['/colegio/create']],
                ['label' => 'Examen', 'url' => ['/examen/create']],
                ['label' => 'Pregunta', 'url' => ['/pregunta/create']],

                Yii::$app->user->isGuest ?
                    ['label' => 'Login', 'url' => ['/site/login']] :
                    [
                        'label' => 'Logout (' . Yii::$app->user->identity->usuario . ')',
                        'url' => ['/site/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ],
            ],
            ]);
        
        }
    }else{
         echo Nav::widget([ 
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
             ['label' => 'Home', 'url' => ['/site/index']],
             ['label'=>'Registrarse','url'=>['/persona/create']],
             ['label' => 'Login', 'url' => ['/site/login']] ,
  
            ]
         ]);
    }
    
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
