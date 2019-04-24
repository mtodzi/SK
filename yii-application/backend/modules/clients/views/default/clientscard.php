<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<!--Карточка заказа --> 
<div id='Block_add_clients-<?=(($model!=null)?$model->id_clients:0)?>' class="row-flex col-lg-6 offset-lg-3" <?=(($model==null)?("style='display: none;'"):'')?>>
    <div class="my_usercard_content_block my-1 mx-1">
        <div class="my_box">
            <!--Начало Хедера карточки-->
            <div class = "my_box_heder">
               <nav class="navbar navbar-light bg-dark rounded-top">
                    <span id='span_clients_id_clients_text-<?=(($model!=null)?$model->id_clients:0)?>' class='navbar-brand text-light'><?=(($model!=null)?'Карточка сотрудника':'Новый клиент')?></span>
                    <?php
                    $buttons_edit = "".   
                        "<!--группировка кнопок в navbar с выравниванием вправо  редактировать-->".
                        "<div id='clients_card_button_edit-".(($model!=null)?$model->id_clients:0)."' class='flex-box ml-auto'>".                             
                            "<!--кнопка редактировать клиента-->".
                            "<a  id='edit_clients_button-".(($model!=null)?$model->id_clients:0)."' class='nav-link btn btn-light clients_edit_button' data-toggle='tooltip' data-placement='right' title='Редактировать'>".
                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/edit.svg'])."' alt='Редактировать'>".
                            "</a>".
                        "</div>".
                        "<!--Конец группировка кнопок в navbar с выравниванием вправо редактировать-->";
                    $buttons_card_apply = "".
                        "<!--группировка кнопок в navbar с выравниванием вправо пременить отмена-->".
                        "<div id='clients_cancel_button_card_apply-".(($model!=null)?$model->id_clients:0)."' class='flex-box ml-auto' ".(($model!=null)?("style='display: none;'"):'')."'>". 
                            "<!--кнопка отменить изменения и вернуться-->".
                            "<a id='clients_cancel_button-".(($model!=null)?$model->id_clients:0)."' class='nav-link btn btn-light mx-1 clients_cancel_button' data-toggle='tooltip' data-placement='left' title='Отмена'>".
                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/abort.svg'])."' alt='Отмена'>".
                            "</a>".
                            "<!--кнопка применить изменения-->".
                            "<a id='clients_apply_button-".(($model!=null)?$model->id_clients:0)."' class='nav-link btn btn-light clients_apply_button' data-toggle='tooltip' data-placement='right' title='Применить'>".
                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/accept.svg'])."' alt='Применить'>".
                            "</a>".
                        "</div>".
                        "<!--Конец группировка кнопок в navbar с выравниванием вправо пременить отмена-->";
                    if(($model!=null)){
                        echo $buttons_edit;
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
                <!-- Информация клиента -->    
                <?php
                    if(($model!=null)){
                        echo $this->render('viewclient', ['model' => $model,]);
                    }                
                ?>
                <!-- Конец Информации Клиента -->
                <!-- Блок редактирования Клиента-->
                <div id = 'clients_form-<?=(($model!=null)?$model->id_clients:0)?>' <?=(($model!=null)?("style='display: none;'"):'')?> >
                    <div class='col py-2'>
                        <div class=''>
                            <form id='form_clients-<?=(($model!=null)?$model->id_clients:0)?>' name='form_clients-<?=(($model!=null)?$model->id_clients:0)?>'>
                                <?=Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), [])?>            
                            </form>
                            <!--div групирует элементы для более удобной подстановки данных на визуализацию не влияет-->
                                <?=$this->render('viewclientform', ['model'=>$model]);?>
                            <!--Конец div id='orders_alert_server-".$model->id_orders." -->                           
                        </div>
                    </div>        
                </div>
                <!--Конец Блок редактирования клиента-->
            </div><!--/.my_box_content -->
        </div><!--/.my_box -->
    </div><!--my_usercard_content_block -->
</div>

