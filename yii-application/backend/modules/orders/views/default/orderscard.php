<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<!--Карточка заказа --> 
<div id='Block_add_orders-<?=(($model!=null)?$model->id_orders:0)?>' class="row-flex col-lg-6 offset-lg-3" <?=(($model==null)?("style='display: none;'"):'')?>>
    <div class="my_usercard_content_block my-1 mx-1">
        <div class="my_box">
            <!--Начало Хедера карточки-->
            <div class = "my_box_heder">
               <nav class="navbar navbar-light bg-dark rounded-top">
                    <span id='span_orders_id_orders_text-<?=(($model!=null)?$model->id_orders:0)?>' class='navbar-brand text-light'><?=(($model!=null)?$model->getOrderNumberText():'Новый заказ')?></span>
                    <?php
                    $buttons_edit_print = "".   
                        "<!--группировка кнопок в navbar с выравниванием вправо печать и редоктировать-->".
                        "<div id='user_card_button_edit_print-".(($model!=null)?$model->id_orders:0)."' class='flex-box ml-auto'>". 
                            "<!--кнопка распечатать заказ-->".
                            "<a id='orders_print_button-".(($model!=null)?$model->id_orders:0)."' class='nav-link btn btn-light mx-1 orders_print_button' data-toggle='tooltip' data-placement='left' title='Печать'>".
                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/print.svg'])."' alt='Печать'>".
                            "</a>".
                            "<!--кнопка редактировать заказ-->".
                            "<a  id='edit_orders_button-".(($model!=null)?$model->id_orders:0)."' class='nav-link btn btn-light orders_edit_button' data-toggle='tooltip' data-placement='right' title='Редактировать'>".
                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/edit.svg'])."' alt='Редактировать'>".
                            "</a>".
                        "</div>".
                        "<!--Конец группировка кнопок в navbar с выравниванием вправо печать и редоктировать-->";
                    $buttons_card_apply = "".
                        "<!--группировка кнопок в navbar с выравниванием вправо пременить отмена-->".
                        "<div id='orders_cancel_button_card_apply-".(($model!=null)?$model->id_orders:0)."' class='flex-box ml-auto' ".(($model!=null)?("style='display: none;'"):'')."'>". 
                            "<!--кнопка отменить изменения и вернуться-->".
                            "<a id='orders_cancel_button-".(($model!=null)?$model->id_orders:0)."' class='nav-link btn btn-light mx-1 orders_cancel_button' data-toggle='tooltip' data-placement='left' title='Отмена'>".
                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/abort.svg'])."' alt='Отмена'>".
                            "</a>".
                            "<!--кнопка применить изменения-->".
                            "<a id='orders_apply_button-".(($model!=null)?$model->id_orders:0)."' class='nav-link btn btn-light orders_apply_button' data-toggle='tooltip' data-placement='right' title='Применить'>".
                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/accept.svg'])."' alt='Применить'>".
                            "</a>".
                        "</div>".
                        "<!--Конец группировка кнопок в navbar с выравниванием вправо пременить отмена-->";
                    if(($model!=null)){
                        echo $buttons_edit_print;
                        echo $buttons_card_apply;
                    }else{
                        echo $buttons_card_apply;
                    }
                    ?>                    
                </nav>
            </div>
            <!--Конец Хедера карточки-->
            <!--Начало контента карточки-->
            <div class="my_box_content rounded-bottom bg-light border border-top-0 border-dark">
                <!-- Информация заказа -->    
                <?php
                    if(($model!=null)){
                        echo $this->render('vieworder', ['model' => $model,]);
                    }                
                ?>
                <!-- Конец Информации заказа -->
                <!-- Блок редактирования заказа-->
                <div id = 'orders_form-<?=(($model!=null)?$model->id_orders:0)?>' <?=(($model!=null)?("style='display: none;'"):'')?> >
                    <div class='col py-2'>
                        <div class=''>
                            <form id='form-update_orders-<?=(($model!=null)?$model->id_orders:0)?>'>
                                <?=Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), [])?>
                                <?=Html :: hiddenInput('OrdersEdit[id_orders]', (($model!=null)?$model->id_orders:0), [])?>
                            </form>
                            <!--div групирует элементы для более удобной подстановки данных на визуализацию не влияет-->
                                <?=$this->render('viewclientform', ['modelOrders'=>$model,'modelClients'=>null]);?>
                            <!--Конец div id='orders_alert_server-".$model->id_orders." -->
                            <h5>Принимаемое устройство:</h5>
                            <!--Блок с чекбоксами диагностика ремонт-->
                            <div id="orders_repair_type-<?=(($model!=null)?$model->id_orders:0)?>">
                                <?=$this->render('checkrepairtype', ['model' => $model,])?>
                            </div>
                            <!--Конец Блок с чекбоксами диагностика ремонт-->
                            <!--Блок c элементами описания техники-->
                            <div id="div_orders_serrial_nambers_id-<?=(($model!=null)?$model->id_orders:0)?>">
                                <?=$this->render('serrialnambersid', ['model' => $model,'modelSerialNumbers'=>null])?>
                            </div>
                            <!--Конец Блок c элементами описания техники-->
                            <div id="div_orders_claimed_malfunction_id-<?=(($model!=null)?$model->id_orders:0)?>">
                                <?=$this->render('claimedmalfunctionid', ['model' => $model,'modelClaimedMalfunctionId'=>null])?>
                            </div>
                        </div>
                    </div>        
                </div>
                <!--Конец Блок редактирования заказа-->
            </div><!--/.my_box_content -->
        </div><!--/.my_box -->
    </div><!--my_usercard_content_block -->
</div>

