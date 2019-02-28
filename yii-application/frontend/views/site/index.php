<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
/*use frontend\assets\AppAsset;*/

$this->title = 'Service Keeper';
?>
<body>
<header">
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
                <a class="nav-link dropdown-toggle" id='menu_link' data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
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
                <a class="nav-link" id='contacts_link' href="#">Контакты</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container" id="main">
    <h2>Автоматизированная система Service Keeper v.1.0</h2>
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-9">
            <p align="justify">Система разработана для использования в небольших сервисных мастерских и предназначена для упрощения 
               решения рутинных задач по автоматизации товарно-кадрового учета, хранения, архивирования и удобного поиска необходимой информации.
               Система реализована при помощи объектно-ориентированного компонентного фреймворка Yii 2 и предусматривает возможности расширения до полноценной CMS.
               При реализации системы использованы технологии адаптивной верстки, Bootstrap 4, HTML 5, CSS3, AJAX, PHP-7, JScript, JQerry...
            </p>
            <hr>
            <p>
               Является элементом портфолио и продуктом совместной работы Зуева Сергея Павловича и Морозова Андрея Алексеевича.
            </p>
        </div>
        <div class='col-xs-12 col-sm-4 col-md-3'>
            <p>Возможности системы:</p>
            <span class='letter_info'>Заказы</span>
            <p align='justify' class='collapse'>Все заказы хранятся в разделе "Заказы", отсортированы по дате поступления. 
               Доступен быстрый поиск заказов  по номеру заказа, модели устройства, ФИО и телефону клиента.
            </p>
            <hr>
            <span class='letter_info'>Клиенты</span>
            <p align='justify' class='collapse'>Контактные данные клиентов заносятся в раздел "Клиенты". 
               Предусмотрен удобный поиск по разделу, а также обновление контактных данных клиента.
            </p>
            <hr>
            <span class='letter_info'>Витрина</span>
            <p align='justify' class='collapse'>В разделе "Витрина" есть возможность быстрого добавления товара на главную 
               страницу сайта с возможностью подбора подходящего изобржения прямо из галереи Google или собственных фотографий. 
               Реализован поиск по товарам, предусмотрена возможность архивирования.
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="card">
                <div class="card-body text-light bg-primary">
                <h3 class="card-title">Название проекта 1</h3>
                <hr>
                <p class="card-text">Текстовое поле для информации о проекте. Пока не используется.</p>
                <a href="#" class='btn btn-light border'>Смотреть проект</a>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="card">
                <div class="card-body text-light bg-dark">
                <h3 class="card-title">Название проекта 2</h3>
                <hr>
                <p class="card-text">Текстовое поле для информации о проекте. Пока не используется.</p>
                <a href="#" class='btn btn-light border'>Смотреть проект</a>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="card">
                <div class="card-body text-light bg-success">
                <h3 class="card-title">Название проекта 3</h3>
                <hr>
                <p class="card-text">Текстовое поле для информации о проекте. Пока не используется.</p>
                <a href="#" class='btn btn-light border'>Смотреть проект</a>
                </div>
            </div>
        </div>
    </div>
    
</div>
    
</body>
