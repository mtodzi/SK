<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use backend\assets\MyAppAssetLayouteSite;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
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
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <header class="header">
        <nav class="navbar ">
            <a id ="buttonMenu" class="navbar-brand btn btn-light" href="#" data-menu="0">
                <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/menu.svg'])?>' alt="Меню">
            </a>
        </nav>
    </header>
    <main id="main" role="main" class="main_content row"> 
        <?= $content ?>    
    </main>

    <footer id="footer" class="footer">
        <p class="right_text_brend">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
    </footer>
    <aside id="aside_left" class="bg-dark aside_left">
            <nav class="navbar">
                <a  class="navbar-brand btn btn-light menu_left" href="<?=Url::to(['/'])?>" data-toggle="tooltip" data-placement="right" title="Главная">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/home_1.svg'])?>' alt="Меню">
                </a>
                <a  class="navbar-brand btn btn-light menu_left" href="<?=Url::to(['/user/user'])?>" data-toggle="tooltip" data-placement="right" title="Сотрудники">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/user_elow.svg'])?>' alt="Сотрудники">
                </a>
                <a  class="navbar-brand btn btn-light menu_left" href="#" data-toggle="tooltip" data-placement="right" title="Сотрудники">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/user_elow.svg'])?>' alt="Меню">
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

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
