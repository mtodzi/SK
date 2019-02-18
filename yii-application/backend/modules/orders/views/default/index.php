<?php

use yii\widgets\ListView;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\orders\assets\MyOrdersAsset;
use backend\modules\orders\models\ClientsPhones;

MyOrdersAsset::register($this);

$this->title = Yii::t('app','Заказы');
?>

<div class='my_heders_bloc row-flex sticky-top'>
    <nav class='navbar navbar-light bg-light border rounded'>
        <a class='navbar-brand' href='<?=Url::to(['/user/user/update'])?>'>Заказы</a>
        <div class='btn-group'>
            <div class='scroll_to_up'>
                <!--кнопка вверх scrollspy-->            
                <a  id = '' class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="В начало">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/arrow-up.svg'])?>' alt="В начало">
                </a>
            </div>
            <div class="mx-1">
                <!--кнопка архив заказов-->            
                <a  id = 'browse_archive_orders' class="btn btn-dark" href="<?=Url::to(['/orders'])?>" data-toggle="tooltip" data-placement="top" title="Смотреть архив заказов">
                <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/addarch.svg'])?>' alt="Смотреть архив заказов">
                </a>
            </div>
            <!--кнопка добавить новый заказ-->
            <div class="">
                <a  id = 'add_new_orders' class="btn btn-dark" href="#" data-toggle="tooltip" data-placement="top" title="Добавить заказ">
                <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/add.svg'])?>' alt="Добавить заказ">
                </a>
            </div>
        </div>
        <form class='form-inline' post="GET" action="<?=Url::to(['/orders'])?>">
            <input name="UserSearch[search]" class='form-control mr-2 my-2' type='search' placeholder='Поиск' value="" aria-label='Search'>
            <button class='btn btn-outline-success my-2' type='submit'>Поиск</button>
        </form>
    </nav>
</div> <!-- ./my_heders_bloc -->

<!-- скрытая переменная открытой карточки -->
<input type="hidden" id="status_card" data-user-card="" name="status_card" value="0">
<!-- конец скрытой переменной открытой карточки -->

<div class='index_orders_bloc'>
    <div class='my_content_bloc'>        
        <!-- пустая карточка заказа --> 
        <div id='Block_add_orders-0' class="row-flex col-lg-6 offset-lg-3" style='display: none;'>
            <div class="my_usercard_content_block my-1 mx-1">
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
                            <div class="col-10 col-xl-2 col-md-2">
                                <form id='form-update_orders-0'>
                                    <?= Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), [])?>
                                </form>
                                <!--div групирует элементы для более удобной подстановки данных на визуализацию не влияет-->
                                <div id='orders_clients_form-0'>
                                    <!--Имя клиента-->
                                    <p class="form-row my-2">
                                        <img class="my_icon mx-1 my-2" src="<?=Url::to(['/img/orders/thumb/client.svg'])?>">
                                        <input id='input_orders_clients_name-0' name='ClientsEdit[clients_name]' form='form-create_orders-0' class="form-control col-10 input_clients_name" type="name" placeholder="*Введите ФИО клиента">
                                        <?=Html :: hiddenInput('OrdersEdit[clients_id]', 0, [])?>
                                    </p>
                                    <p id = 'error_orders_client-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                    <!--Конец Имя клиента-->
                                    
                                    <!--Телефон клиента-->
                                    <p id='p_orders_clients_phone-0-1' class="form-row my-2 orders_phone-0 orders_phone">
                                        <img class="my_icon mx-1 my-2" src="<?=Url::to(['/img/smartphone-call.svg'])?>">
                                        <input id='input_orders_clients_phone-0-1' name='ClientsPhonesEdit[phone_number-1]'  form='' class="form-control col-10 phone phone_input" type="text" placeholder="*Введите номер телефона">
                                        <p id = 'error_orders_phone-0-1' class='text-danger my-2 mx-2 error_orders_phone-0' style='display: none;'>Ошибка</p>
                                    </p>
                                    <p class="form-row my-2">
                                        <a  id = 'add_another_phone-0' class="btn btn-dark add_another_phone mx-1" href="#" data-count-phone='1' data-toggle="tooltip" data-placement="right" title="Добавить еще телефон">
                                            <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/add.svg'])?>' alt="Добавить еще телефон">
                                        </a>
                                    </p>    
                                    <!--Конец Телефон клиента-->
                                    <p class="form-row my-2"><img class="my_icon mx-1 my-2" src="<?=Url::to(['/img/mail.svg'])?>"> <input id='input_user_email-0' name='' form='' class="form-control col-10" type="mail" placeholder="Введите адрес электронной почты"> </p>
                                    <p id = 'error_user_email-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                    <p class="form-row my-2"><img class="my_icon mx-1 my-2" src="<?=Url::to(['/img/home.svg'])?>"> <input id='input_user_address-0' name='' form='' class="form-control col-10" type="text" placeholder="Введите домашний адрес"> </p>
                                    <p id = 'error_user_address-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                </div>
                                <!--Конец Div id='orders_clients_form-0'-->
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
                                <p class='form-row my-2 mx-2'> <textarea style='resize: none; ' rows="3" cols="70" maxlength="300" placeholder="Особые заметки при приёме"></textarea></p>
                                <p id = 'error_device_type-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                            </div>
                        </div>    
                    </div> <!--/.my_box_content -->
                </div> <!--/.my_box -->
            </div> <!--my_usercard_content_block -->
        </div>
<?php
        echo ListView::widget([
                'dataProvider' => $dataProvider,
                'pager' => [
                    'maxButtonCount' => 3,
                    // Customzing options for pager container tag
                    'options' => [
                        'tag' => 'ul',
                        'class'=>'pagination my-2 justify-content-center'   
                    ],
                    // Customzing CSS class for pager link
                    'linkContainerOptions'=>[
                        'class'=>'page-item'
                    ],
                    'linkOptions' => [
                        'class' => 'page-link'
                    ],
                    
                    'activePageCssClass' => 'active',
                    'disabledPageCssClass' => 'disable disabled page-link',
                    
                     
                ],
                'options'=> ['class' => 'wrapper'],
                'itemOptions' => ['class' => 'row-flex col-lg-6 offset-lg-3'],
                'summary'=>FALSE,
                'itemView' => function ($model, $key, $index, $widget) {
                //Начало формирования телефонов клиентов для редактирования
                    $ClientsPhones = ClientsPhones::findAll(['clients_id'=>$model->clients_id]);
                    $count = count($ClientsPhones);
                    $phonestr = "";
                    $i=1;
                    foreach ($ClientsPhones as $phone){
                        $phonestr = $phonestr."".
                            "<p id='p_orders_clients_phone-".$model->id_orders."-".$i."' class='form-row my-2 orders_phone-".$model->id_orders." orders_phone'>".
                                "<img class='my_icon mx-1 my-2' src='".Url::to(['/img/smartphone-call.svg'])."'>".
                                "<input id='input_orders_clients_phone-".$model->id_orders."-".$i."' name='ClientsPhonesEdit[phone_number-".$i."]' value='".$phone->phone_number."'  form='' class='form-control col-10 phone phone_input' type='text' placeholder='*Введите номер телефона'>";
                                if($count>1){
                                $phonestr = $phonestr."".
                                    "<a  id = 'delete_another_phone-".$model->id_orders."-".$i."' class='btn btn-dark delete_another_phone mx-1' href='#' data-count-phone='".$count."' data-toggle='tooltip' data-placement='right' title='Удалить телефон'>".
                                        "<img id ='menu_navbar_top' class='' src='/yii-application/backend/web/m_orders/img/minus.svg' alt='Удалить телефон'>".
                                    "</a>";
                                }
                                $phonestr = $phonestr."".        
                                "<p id = 'error_orders_phone-".$model->id_orders."-".$i."' class='text-danger my-2 mx-2 error_orders_phone-".$model->id_orders."' style='display: none;'>Ошибка</p>".                             
                            "</p>";
                        $i++;
                    }
                    $phonestr = $phonestr."".
                    "<p class='form-row my-2'>".
                        "<a  id = 'add_another_phone-".$model->id_orders."' class='btn btn-dark add_another_phone mx-1' href='#' data-count-phone='".$count."' data-toggle='tooltip' data-placement='right' title='Добавить еще телефон'>".
                            "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/add.svg'])."' alt='Добавить еще телефон'>".
                        "</a>".
                    "</p>";
                //Конец формирования телефонов клиентов для редактирования
                $bloc = "".
                    "<!-- пустая карточка заказа сформированная-->". 
                    "<div id='Block_add_orders-".$model->id_orders."' class=''>".
                        "<div class='my_usercard_content_block my-1 mx-1'>".
                            "<div class='my_box'>".
                                "<div class = 'my_box_heder'>".
                                    "<nav class='navbar navbar-light bg-dark rounded-top'>".
                                        "<span id='span_orders_id_orders_text-".$model->id_orders."' class='navbar-brand text-light'>".$model->getOrderNumberText()."</span>".                            
                                        "<!--группировка кнопок в navbar с выравниванием вправо печать и редоктировать-->".
                                        "<div id='user_card_button_edit_print-".$model->id_orders."' class='flex-box ml-auto'>". 
                                            "<!--кнопка распечатать заказ-->".
                                            "<a id='orders_print_button-".$model->id_orders."' class='nav-link btn btn-light mx-1 orders_print_button' data-toggle='tooltip' data-placement='left' title='Печать'>".
                                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/print.svg'])."' alt='Печать'>".
                                            "</a>".
                                            "<!--кнопка редактировать заказ-->".
                                            "<a  id='edit_orders_button-".$model->id_orders."' class='nav-link btn btn-light orders_edit_button' data-toggle='tooltip' data-placement='right' title='Редактировать'>".
                                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/edit.svg'])."' alt='Редактировать'>".
                                            "</a>".
                                        "</div>".
                                        "<!--группировка кнопок в navbar с выравниванием вправо пременить  отмена-->".
                                        "<div id='orders_cancel_button_card_apply-".$model->id_orders."' class='flex-box ml-auto' style='display: none;'>". 
                                            "<!--кнопка отменить изменения и вернуться-->".
                                            "<a id='orders_cancel_button-".$model->id_orders."' class='nav-link btn btn-light mx-1 orders_cancel_button' data-toggle='tooltip' data-placement='left' title='Отмена'>".
                                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/abort.svg'])."' alt='Отмена'>".
                                            "</a>".
                                            "<!--кнопка применить изменения-->".
                                            "<a id='orders_apply_button-".$model->id_orders."' class='nav-link btn btn-light orders_apply_button' data-toggle='tooltip' data-placement='right' title='Применить'>".
                                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/accept.svg'])."' alt='Применить'>".
                                            "</a>".
                                        "</div>".
                                    "</nav>".
                                "</div>".             
                                "<div class='my_box_content rounded-bottom bg-light border border-top-0 border-dark'>".
                                    "<div id = 'orders_content-".$model->id_orders."'>".
                                        "<div class='row py-2'>".
                                            "<div class='px-4 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12'>".
                                                "<form id='form-update_orders-0'>".
                                                    Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), []).
                                                "</form>".
                                                "<div id='user_alert_server-0' class='alert alert-danger' role='alert' style='display: none;'>".
                                                    "<span id='span_user_alert_server-0'>Ошибка</span>".
                                                "</div>".
                                                "<h5>".
                                                    "<p class='form-row mx-4 my-1'>".$model->clients->clients_name." // тел: ".$model->getOnePhoneClient()."</p>".
                                                "</h5>".
                                                "<p class='form-row mx-4 my-1'>".$model->getRepairTypeString()."</p>".
                                                "<p class='form-row mx-4 my-1'>".$model->getDevicesText()."</p>".
                                                "<p class='form-row mx-4 my-1'>".$model->claimedMalfunction->claimed_malfunction_name."</p>".
                                            "</div>".
                                        "</div>".
                                    "</div>".
                                    "<div id = 'orders_form-".$model->id_orders."' style='display: none;'>".
                                        "<div class='row py-2'>".
                                            "<div class='px-4 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12'>".
                                                "<form id='form-update_orders-".$model->id_orders."'>".
                                                    Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), []).
                                                    Html :: hiddenInput('OrdersEdit[id_orders]', $model->id_orders, []).
                                                "</form>".
                        
                                                "<!--div групирует элементы для более удобной подстановки данных на визуализацию не влияет-->".
                                                "<div id='orders_clients_form-".$model->id_orders."'>".    
                                                    "<p class='form-row my-2'><img class='my_icon mx-1 my-2' src='".Url::to(['/img/orders/thumb/client.svg'])."'> <input id='input_orders_clients_name-".$model->id_orders."' name='ClientsEdit[clients_name]' value='".$model->clients->clients_name."' form='form-create_orders-0' class='form-control col-10 input_clients_name' type='name' placeholder='*Введите ФИО клиента'> </p>".
                                                    Html :: hiddenInput('OrdersEdit[clients_id]', $model->clients_id, []).
                                                    "<p id = 'error_orders_clients_name-".$model->id_orders."' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>".
                                                    
                                                    "<!--Телефон клиента-->".
                                                    $phonestr.                                                        
                                                    "<!--Телефон клиента-->".
                        
                                                "</div>".
                                                "<!--Конец div id='orders_alert_server-".$model->id_orders." -->".
                        
                                            "</div>".
                                        "</div>".        

                                    "</div>".
                                "</div>".
                            "</div>".
                        "</div>".
                    "</div>".
                    "<!--Конец карточки-->";    
                return $bloc;
            },
        ]);
     ?>    
        
    </div>
    <div class='my_footer_bloc co-12'>
    </div>
</div>

        
