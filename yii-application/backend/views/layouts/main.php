<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use backend\assets\MyAppAssetLayouteSite;
use yii\helpers\Html;
use yii\helpers\Url;
AppAsset::register($this);
MyAppAssetLayouteSite::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    
    <header class="header">
        <nav class="navbar">
            <a id ="buttonMenu" class="navbar-brand btn btn-light" href="#" data-menu="0">
                <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/menu.svg'])?>' alt="Меню">
            </a>
            <p id ="currentUser" class="navbar_inner_content d-none d-lg-block d-xl-block">
                Выполнен вход: <span id = 'userName'><?=Yii::$app->user->identity->employeename?></span>
            </p>
        </nav>
    </header>
    
    <aside id="aside_left" class="bg-dark aside_left">
            <nav id='leftmen' class="navbar">
                <a  id='menuB' class="navbar-brand btn btn-light menu_left <?=(Yii::$app->request->pathInfo=='')?'active focus':''?>" href="<?=Url::to(['/'])?>" data-toggle="tooltip" data-placement="right" title="Главная">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/home_1.svg'])?>' alt="Меню">
                </a>
                <a  id='ordersB' class="navbar-brand btn btn-light menu_left <?=(Yii::$app->request->pathInfo=='orders')?'active focus':''?>" href="<?=Url::to(['/orders'])?>" data-toggle="tooltip" data-placement="right" title="Заказы">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/orders.svg'])?>' alt="Заказы">
                </a>
                <a  class="navbar-brand btn btn-light menu_left <?=(Yii::$app->request->pathInfo=='clients')?'active focus':''?>" href="<?=Url::to(['/clients'])?>" data-toggle="tooltip" data-placement="right" title="Клиенты">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/clients.svg'])?>' alt="Клиенты">
                </a>
                <a  class="navbar-brand btn btn-light menu_left <?=(Yii::$app->request->pathInfo=='showcase')?'active focus':''?>" href="<?=Url::to(['/showcase'])?>" data-toggle="tooltip" data-placement="right" title="Витрина">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/showcase.svg'])?>' alt="Витрина">
                </a>
                <a  class="navbar-brand btn btn-light menu_left <?=(Yii::$app->request->pathInfo=='stock')?'active focus':''?>" href="<?=Url::to(['/stock'])?>" data-toggle="tooltip" data-placement="right" title="Склад">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/stock.svg'])?>' alt="Склад">
                </a>
                <a  class="navbar-brand btn btn-light menu_left <?=(Yii::$app->request->pathInfo=='user/user')?'active focus':''?>" href="<?=Url::to(['/user/user'])?>" data-toggle="tooltip" data-placement="right" title="Сотрудники">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/user.svg'])?>' alt="Сотрудники">
                </a>
            </nav>
            <nav class="navbar exit">
            <?php    
                echo Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        '',
                        ['class' => 'navbar-brand btn btn-light exit_img','data-toggle'=>'tooltip','data-placement'=>'right', 'title'=>'Выход']
                    )
                    . Html::endForm() ;
            ?>
            </nav>      
    </aside>
    
    <main id="main" role="main" class="main_content container-fluid">
        
           <?= $content ?>   
          
    </main>

    <footer id="footer" class="footer">
        <p class="right_text_brend">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
    </footer>
    
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
