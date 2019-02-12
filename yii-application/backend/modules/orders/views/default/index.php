<?php

use yii\widgets\ListView;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\assets\AssetKartikFileInput;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//$this->registerCssFile('@web/fuser/css/user.css');
AssetKartikFileInput::register($this);
$this->title = Yii::t('app', 'Заказы');


?>
<div class='index_orders_bloc row'>
    <div class='my_heders_bloc sticky-top mx-auto col-12'>
        <nav class='navbar navbar-light bg-light border rounded'>
            <a class='navbar-brand' href='<?=Url::to(['/user/user/update'])?>'>Заказы</a>
            <div class="d-flex justify-content-start col-xl-5 col-lg-4 col-md-4 col-sm-9 col-10"> 
                <div>
                <!--кнопка архив заказов-->            
                <a  id = 'browse_archive_orders' class="btn btn-dark mx-1" href="<?=Url::to(['/orders'])?>" data-toggle="tooltip" data-placement="top" title="Смотреть архив заказов">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/addarch.svg'])?>' alt="Смотреть архив заказов">
                </a>
                </div>
                <!--кнопка добавить новый заказ-->
                <div class="ml-auto">
                <a  id = 'add_new_orders' class="btn btn-dark mx-1" href="#" data-toggle="tooltip" data-placement="top" title="Добавить заказ">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/add.svg'])?>' alt="Добавить заказ">
                </a>
                </div>
                    
            </div>
            <form class='form-inline' post="GET" action="<?=Url::to(['/orders'])?>">
                <input name="UserSearch[search]" class='form-control mr-2 my-2' type='search' placeholder='Поиск' value="<?=$searchModel->search?>" aria-label='Search'>
                <button class='btn btn-outline-success my-2' type='submit'>Поиск</button>
            </form>
        </nav>
    </div>
   <input type="hidden" id="status_card" data-user-card="" name="status_card" value="0">  <!-- переменная открытой карточки нового заказа-->
    <div class='my_content_bloc col-10'>        
        <!-- пустая карточка заказа --> 
        <div id='Block_add_orders' class="row" style='display: block;'>
            <div class="my_usercard_content_block col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12  my-1 mx-auto">
                <div class="my_box">
                    <div class = "my_box_heder">
                        <nav class="navbar navbar-light bg-dark rounded-top">
                            <span class="navbar-brand text-light">Новый заказ</span>
                            
                            <!--группировка кнопок в navbar с выравниванием вправо-->
                                <div class="flex-box ml-auto"> 
                                <!--кнопка отменить изменения и вернуться-->
                                    <a id='orders_cancel_button-0' class="nav-link btn btn-light mx-1 orders_cancel_button" data-toggle="tooltip" data-placement="left" title="Отмена">
                                        <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/abort.svg'])?>' alt="Отмена">
                                    </a>
                                <!--кнопка применить изменения-->
                                    <a  id='apply_add_new_orders-0' class="nav-link btn btn-light orders_apply_button" data-toggle="tooltip" data-placement="right" title="Сформировать">
                                        <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/accept.svg'])?>' alt="Сформировать">
                                    </a>
                                </div>
                        
                        </nav>
                    </div>             
                    <div class="my_box_content rounded-bottom bg-light border border-top-0 border-dark">
                        <div class="row py-2">
                            <div class="px-4 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">
                                <form id='form-update_orders-0'>
                                    <?= Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), [])?>
                                </form>
                                <div id='user_alert_server-0' class='alert alert-danger' role='alert' style='display: none;'>
                                    <span id='span_user_alert_server-0'>Ошибка</span>
                                </div>
                                <h5>
                                    <p class="form-row my-2"><img class="my_icon mx-1 my-2" src="<?=Url::to(['/img/orders/thumb/client.svg'])?>"> <input id='input_orders_client-0' name='' form='form-create_orders-0' class="form-control col-10" type="name" placeholder="*Введите ФИО клиента"> </p>
                                    <p id = 'error_orders_client-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                </h5>    
                                <p id = 'error_user_employeename-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                <p id = 'error_user_id_position-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                <p class="form-row my-2"><img class="my_icon mx-1 my-2" src="<?=Url::to(['/img/smartphone-call.svg'])?>"> <input id='input_user_phone-0' name=''  form='' class="form-control col-10 phone" type="text" placeholder="*Введите номер телефона"></p>
                                <p id = 'error_user_phone-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                <p class="form-row my-2"><img class="my_icon mx-1 my-2" src="<?=Url::to(['/img/mail.svg'])?>"> <input id='input_user_email-0' name='' form='' class="form-control col-10" type="mail" placeholder="Введите адрес электронной почты"> </p>
                                <p id = 'error_user_email-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                <p class="form-row my-2"><img class="my_icon mx-1 my-2" src="<?=Url::to(['/img/home.svg'])?>"> <input id='input_user_address-0' name='' form='' class="form-control col-10" type="text" placeholder="Введите домашний адрес"> </p>
                                <p id = 'error_user_address-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                <h5>
                                    Принимаемое устройство:
                                </h5> 
                                <div class='form-check form-check-inline'>
                                    <input class='form-check-input' type='checkbox' id='check_diagnostics-' value='option1'>
                                    <label class='form-check-label' for='check_diagnostics-'>диагностика</label>
                                </div>
                                <div class='form-check form-check-inline'>
                                    <input class='form-check-input' type='checkbox' id='check_repair-' value='option2'>
                                    <label class="form-check-label" for="check_repair-">ремонт</label>
                                </div>
                                <p class="form-row my-2"> <input id='input_brand-0' name=''  form='' class="form-control col-4 mx-2" type="text" placeholder="Бренд"></p>
                                <p id = 'error_brand-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                <p class="form-row my-2"> <input id='input_device_type-0' name='' form='' class="form-control col-6 mx-2" type="text" placeholder="Тип устройства"> </p>
                                <p id = 'error_device_type-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                <p class="form-row my-2"> <input id='input_model_name-0' name='' form='' class="form-control col-6 mx-2" type="text" placeholder="Модель устройства"> </p>
                                <p id = 'error_device_type-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                <p class="form-row my-2"> <input id='input_serial_number-0' name='' form='' class="form-control col-4 mx-2" type="text" placeholder="Серийный номер"> </p>
                                <p id = 'error_device_type-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                <p class="form-row my-2"> <input id='input_malfunction-0' name='' form='' class="form-control col-10 mx-2" type="text" placeholder="Заявленная неисправность"> </p>
                                <p id = 'error_device_type-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                <p class="form-row my-2"> <input id='input_condition-0' name='' form='' class="form-control col-10 mx-2" type="text" placeholder="Внешний вид"> </p>
                                <p id = 'error_device_type-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                <p class="form-row my-2">
                                    <select id='input_contractor' form='' name='' class="form-control col-6 mx-2"> 
                                        <option selected value='0'>Назначить исполнителя</option>
                                        <option value='3'>Батасов</option>
                                        <option value='2'>Морозов</option>
                                        <option value='1'>Тестович</option>
                                    </select>
                                </p>
                                <div class='form-check form-check-inline'>
                                    <input class='form-check-input'  type='checkbox' id='check_urgency-' value='option3'>
                                    <label class='form-check-label' for='check_urgency-'> срочно! </label>
                                </div>
                                <p class='form-row my-2 mx-2'> <textarea style='resize: none;' rows="3" cols="70" maxlength="300" placeholder="Особые заметки при приёме"></textarea></p>
                                <p id = 'error_device_type-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
 
                <!-- пустая карточка заказа сформированная--> 
        <div id='Block_add_orders' class="row" style='display: block;'>
            <div class="my_usercard_content_block col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12  my-1 mx-auto">
                <div class="my_box">
                    <div class = "my_box_heder">
                        <nav class="navbar navbar-light bg-dark rounded-top">
                            <span class="navbar-brand text-light">Заказ № __ от __ __ ____</span>
                            
                            <!--группировка кнопок в navbar с выравниванием вправо-->
                                <div class="flex-box ml-auto"> 
                                <!--кнопка распечатать заказ-->
                                    <a id='orders_print_button' class="nav-link btn btn-light mx-1 orders_print_button" data-toggle="tooltip" data-placement="left" title="Печать">
                                        <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/print.svg'])?>' alt="Печать">
                                    </a>
                                <!--кнопка редактировать заказ-->
                                    <a  id='edit_orders' class="nav-link btn btn-light orders_edit_button" data-toggle="tooltip" data-placement="right" title="Редактировать">
                                        <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/edit.svg'])?>' alt="Редактировать">
                                    </a>
                                </div>
                        
                        </nav>
                    </div>             
                    <div class="my_box_content rounded-bottom bg-light border border-top-0 border-dark">
                        <div class="row py-2">
                            <div class="px-4 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">
                                <form id='form-update_orders-0'>
                                    <?= Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), [])?>
                                </form>
                                <div id='user_alert_server-0' class='alert alert-danger' role='alert' style='display: none;'>
                                    <span id='span_user_alert_server-0'>Ошибка</span>
                                </div>
                                <h5>
                                    <p class="form-row mx-4 my-1">Клиентов Клиент Клиентович // тел: 8(111)-111-11-11</p>
                                    <p id = 'error_orders_client-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                </h5>    
                                <p id = 'error_user_employeename-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                <p id = 'error_user_id_position-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                <p class="form-row mx-4 my-1">Диагностика, ремонт</p>
                                <p id = 'error_brand-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                <p class="form-row mx-4 my-1">Apple смартфон I-phone 6S S/N:3213213213</p>
                                <p id = 'error_device_type-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                <p class="form-row mx-4 my-1">Не раб. кнопка вкл. тел. и выкл. громк. после попадания влаги</p>
                                <p id = 'error_device_type-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='my_footer_bloc co-12'>
    </div>
</div>
        
