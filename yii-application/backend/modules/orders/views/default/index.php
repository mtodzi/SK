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
$this->title = Yii::t('app', 'Персонал');


?>
<div class='index_orders_bloc row'>
    <div class='my_heders_bloc col-xl-9 col-lg-9 col-md-11 col-sm-11 col-8'>
        <nav class='navbar navbar-light bg-light'>
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
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12  my-1">
                <div class="my_box">
                    <div class = "my_box_heder">
                        <nav class="navbar navbar-light bg-dark rounded-top">
                            <span class="navbar-brand text-light">Новый заказ</span>
                            
                            <!--группировка кнопок в navbar с выравниванием вправо-->
                                <div class="flex-box ml-auto"> 
                                <!--кнопка распечатать заказ-->
                                    <a id='orders_print_button-0' class="nav-link btn btn-light user_cancel_button" data-toggle="tooltip" data-placement="left" title="Печать">
                                        <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/abort.svg'])?>' alt="Печть">
                                    </a>
                                <!--кнопка отменить изменения и вернуться-->
                                    <a id='orders_cancel_button-0' class="nav-link btn btn-light mx-1 user_cancel_button" data-toggle="tooltip" data-placement="left" title="Отмена">
                                        <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/abort.svg'])?>' alt="Отмена">
                                    </a>
                                <!--кнопка применить изменения-->
                                    <a  id='apply_add_new_orders-0' class="nav-link btn btn-light user_apply_button" data-toggle="tooltip" data-placement="right" title="Применить">
                                        <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/accept.svg'])?>' alt="Применить">
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
                                        Устройство и неисправности
                                    </h5>   
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
                                    <p class=' my-2 mx-2'> <textarea class='form-row' style='resize: none;' rows="3" cols="70" autofocus maxlength="300" placeholder="Особые заметки"></textarea></p>
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
        
