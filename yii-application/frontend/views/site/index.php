<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'Service Keeper';
?>
<body>
<header class="text-start p-1">
    <img id ='header_logo_small' class='img-fluid img_header' src='<?=Url::to(['/img/Logo_SK_small.svg'])?>' alt='Лого'
</header>
<nav class="navbar navbar-expand-sm navbar-light" data-toggle="affix">
    <a class="navbar-brand img_nav" href="#" style='display: none;' >
        <img src="/img/Logo_SK_white.svg" width="45" height="45" class="d-inline-block align-top" alt="" >
        <span class='letter_red'>Service Keeper</span>
    </a>
     
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
        ☰
    </button>
    <div class="collapse navbar-collapse" id="collapsingNavbar">

        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    Меню сайта
                </a>
                <div class="dropdown-menu" aria-labelledby="Preview">
                    <a class="dropdown-item" href="">Вверх</a>

                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Услуги</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="#"></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="#">Контакты</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container" id="main">
    <h2>Автоматизированная система Service Keeper v.1.0</h2>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-9">
            <p>Система разработана для использования в небольших сервисных мастерских и предназначена для упрощения 
               решения рутинных задач по автоматизации товарно-кадрового учета, хранения, архивирования и удобного поиска необходимой информации.
               Система реализована при помощи объектно-ориентированного компонентного фреймворка Yii 2 и предусматривает возможности расширения до полноценной CMS.
               При реализации системы использованы технологии адаптивной верстки, Bootstrap 4, HTML 5, AJAX...
               Является элементом портфолио и продуктом совместной работы Зуева Сергея Павловича и Морозова Андрея Алексеевича.
            </p>
        </div>
        <div class="col-xs-6 col-md-3">
            <p>Возможности системы:</p>
            <span class='letter_info'>Управление заказами</span>
            <p>Все заказы хранятся в специальном разделе "Заказы", отсортированы по дате поступления. 
               Доступен быстрый поиск заказов  по номеру заказа, модели устройства, ФИО и телефону клиента.
            </p>
            <hr>
            <span class='letter_info'>База клиентов</span>
            <p>Контактные данные клиентов заносятся в раздел "Клиенты". 
               Предусмотрен удобный поиск по разделу, а также обновление контактных данных клиента.
            </p>
            <hr>
            <span class='letter_info'>Витрина</span>
            <p>В разделе "Витрина" реализована возможность быстрого добавления товара на главную 
               страницу сайта с возможностью подбора подходящего изобржения прямо из галереи Google или собственных фотографий. 
               Реализован поиск по товарам, предусмотрена возможность архивирования.
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-4">
            <div class="card card-outline-primary">
               <div class="card-block">
               <h3 class="card-title">Карточка</h3>
                <p class="card-text">Текстовое поле для дополнительной информации. Пока не используется.</p>
                    <a href="#" class="btn btn-outline-secondary">Контур кнопка</a>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-4">
            <div class="card card-outline-primary">
               <div class="card-block">
               <h3 class="card-title">Карточка</h3>
                <p class="card-text">Текстовое поле для дополнительной информации. Пока не используется.</p>
                    <a href="#" class="btn btn-outline-secondary">Контур кнопка</a>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-4">
            <div class="card card-outline-primary">
               <div class="card-block">
               <h3 class="card-title">Карточка</h3>
                <p class="card-text">Текстовое поле для дополнительной информации. Пока не используется.</p>
                    <a href="#" class="btn btn-outline-secondary">Контур кнопка</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
