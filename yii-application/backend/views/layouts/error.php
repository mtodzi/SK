<?php?>
<div class="wrapper">
        <header>
            <nav class="navbar ">
                <a class="navbar-brand btn btn-light" href="#">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['img/menu.svg'])?>' alt="Меню">
                </a>    
            </nav>
        </header>
        <aside id="aside_left" class="bg-dark">
             <img id ="logo_aside_top" class="" src='<?=Url::to(['img/logo_v1.svg'])?>' alt="Меню">
        </aside>
        <div class="container-fluid">
            <?= $content ?>
        </div>
        <footer>            
            <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        </footer>
    </div>

    position: absolute;
    bottom: 0;
    width: 100%;
    height: 60px;
    line-height: 60px;
    background-color: #f5f5f5;
    
    header{
    z-index: 1;
}
#menu_navbar_top{
    z-index: 1;
    width: 25px;
    height: 25px;
}
#logo_aside_top{
    width: 50px;
    height: 25px;
    background-color: red;
}
#aside_left{
    position: absolute;
    width: 85px;
    height: 100%;
}
.content{
    position: absolute;
    top: 50px;
    left: 100px;
}
.footer{
    position: absolute;
    bottom: 0;
    width: 100%;
    height: 60px;
    line-height: 60px;
    background-color: #f5f5f5;
}
.footer p {
    margin-bottom: 0px;
}