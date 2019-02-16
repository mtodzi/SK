<?php
use yii\helpers\Url;
use yii\helpers\Html;

$client = "".
    "<div id='orders_clients_form-".$modelOrders->id_orders."'>".    
        "<p class='form-row my-2'><img class='my_icon mx-1 my-2' src='".Url::to(['/img/orders/thumb/client.svg'])."'> <input id='input_orders_clients_name-".$modelOrders->id_orders."' name='ClientsEdit[clients_name]' value='".$modelClients->clients_name."' form='form-create_orders-0' class='form-control col-10 input_clients_name' type='name' placeholder='*Введите ФИО клиента'> </p>".
        Html :: hiddenInput('OrdersEdit[clients_id]', $modelClients->id_clients, []).
        "<p id = 'error_orders_clients_name-".$modelOrders->id_orders."' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>". 
    "</div>";
echo $client;
