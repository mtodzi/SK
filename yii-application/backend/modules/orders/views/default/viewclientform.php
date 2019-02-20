<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\orders\models\ClientsPhones;


//Начало формирования телефонов клиентов для редактирования
$ClientsPhones = ClientsPhones::findAll(['clients_id'=>$modelClients->id_clients]);
$count = count($ClientsPhones);
$phonestr = "";
$i=1;
foreach ($ClientsPhones as $phone){
    $phonestr = $phonestr."".
    "<div id = 'div_orders_clients_phone-".$model->id_orders."-".$i."'>".         
        "<p id='p_orders_clients_phone-".(($modelOrders)?$modelOrders->id_orders:"0")."-".$i."' class='form-row my-2 orders_phone-".(($modelOrders)?$modelOrders->id_orders:"0")." orders_phone'>".
            "<img class='my_icon mx-1 my-2' src='".Url::to(['/img/smartphone-call.svg'])."'>".
            "<input id='input_orders_clients_phone-".(($modelOrders)?$modelOrders->id_orders:"0")."-".$i."' name='ClientsPhonesEdit[phone_number-".$i."]' value='".$phone->phone_number."'  form='' class='form-control col-10 phone phone_input phone_input-".(($modelOrders)?$modelOrders->id_orders:"0")."' type='text' placeholder='*Введите номер телефона'>";
            if($count>1){
                $phonestr = $phonestr."".
                "<a  id = 'delete_another_phone-".(($modelOrders)?$modelOrders->id_orders:"0")."-".$i."' class='btn btn-dark delete_another_phone mx-1' href='#' data-count-phone='".$count."' data-toggle='tooltip' data-placement='right' title='Удалить телефон'>".
                    "<img id ='menu_navbar_top' class='' src='/yii-application/backend/web/m_orders/img/minus.svg' alt='Удалить телефон'>".
                "</a>";
            }
    $phonestr = $phonestr."".        
        "<p id = 'error_orders_clients_phone-".(($modelOrders)?$modelOrders->id_orders:"0")."-".$i."' class='text-danger my-2 mx-2 error_orders_phone-".(($modelOrders)?$modelOrders->id_orders:"0")."' style='display: none;'>Ошибка</p>".                             
        "</p>".
    "</div>";
    $i++;
}
$phonestr = $phonestr."".
    "<p class='form-row my-2'>".
        "<a  id = 'add_another_phone-".(($modelOrders)?$modelOrders->id_orders:"0")."' class='btn btn-dark add_another_phone mx-1' href='#' data-count-phone='".$count."' data-toggle='tooltip' data-placement='right' title='Добавить еще телефон'>".
            "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/add.svg'])."' alt='Добавить еще телефон'>".
        "</a>".
    "</p>";
//Конец формирования телефонов клиентов для редактирования
$client = "".
    "<div id='orders_clients_form-".(($modelOrders)?$modelOrders->id_orders:"0")."'>".    
        "<p class='form-row my-2'><img class='my_icon mx-1 my-2' src='".Url::to(['/img/orders/thumb/client.svg'])."'> <input id='input_orders_clients_name-".(($modelOrders)?$modelOrders->id_orders:"0")."' name='ClientsEdit[clients_name]' value='".$modelClients->clients_name."' form='form-create_orders-0' class='form-control col-10 input_clients_name' type='name' placeholder='*Введите ФИО клиента'>". 
            Html :: hiddenInput('OrdersEdit[clients_id]', $modelClients->id_clients, []).
            "<p id = 'error_orders_clients_name-".(($modelOrders)?$modelOrders->id_orders:"0")."' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>".
        "</p>".
        "<!--Телефон клиента-->".
            $phonestr.                                                        
        "<!--Телефон клиента-->".
    "</div>";
echo $client;
