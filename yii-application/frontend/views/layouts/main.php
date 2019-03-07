<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Url;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\assets\MyAppAsset;

AppAsset::register($this);
MyAppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    
    <div class="container">
       
    <header class='linkblock' onclick="location.href='<?=Url::to(['site/index'])?>';">
    <div class="jumbotron jumbotron-fluid">
        <video autoplay muted loop src="/vidz/background_video.webm"> </video>
            <div class="container">
            <img id ='header_logo_small' class='img-fluid img_header' src='<?=Url::to(['/img/Logo_SK_small.svg'])?>' alt='Лого'>
            </div><!-- /.container -->
    </div> <!-- /.jumbotron -->
</header>
    
<nav class="navbar navbar-expand-sm navbar-light" data-toggle="affix">
    <a class="navbar-brand img_nav" href="#" style='display: none;' >
        <img src="/img/Logo_SK_white.svg" width="45" height="45" class="d-inline-block align-top" alt="" >
    </a>
     
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
         ☰ 
    </button>
    <div class="collapse navbar-collapse" id="collapsingNavbar">

        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id='menu_link' data-toggle="dropdown" href="" role="button" aria-haspopup="true" aria-expanded="false">
                    Меню сайта
                </a>
                <div class="dropdown-menu" aria-labelledby="Вверх">
                    <a class="dropdown-item disabled" href="#">Вверх</a>

                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" id='showcase_link' href="#">Витрина</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" id='services_link' href="#">Услуги</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" id='orders_link' href="#">Заказы</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link <?=(Yii::$app->request->pathInfo=='site/contact')?'active focus':''?>" id='contacts_link' href='<?=Url::to(['site/contact'])?>'>Контакты</a>
            </li>
        </ul>
    </div>
</nav>
        
        <?= $content ?>
    </div> <!-- /.container -->
</div> <!-- /.wrap -->

<footer id="footer" class="footer">
        <p class="right_text_brend">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
