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
               <nav class="navbar navbar-light <?=(($model!=null && $model->urgency == 1)?'bg-danger':'bg-dark')?>  rounded-top">
                    <span id='span_orders_id_orders_text-<?=(($model!=null)?$model->id_orders:0)?>' class='navbar-brand text-light'><?=(($model!=null)?$model->getOrderNumberText():'Новый заказ')?></span>
                    <?php
                    $buttons_edit_print = "".   
                        "<!--группировка кнопок в navbar с выравниванием вправо вправо закрыть печать и редактировать-->".
                        "<div id='user_card_button_edit_print-".(($model!=null)?$model->id_orders:0)."' class='flex-box ml-auto'>". 
                            "<!--кнопка открыть заказ-->".
                            "<a id='orders_open_button-".(($model!=null)?$model->id_orders:0)."' class='nav-link btn btn-light orders_open_button' data-toggle='tooltip' data-placement='left' title='Открыть заказ'>".
                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/recover_arch.svg'])."' alt='Открыть заказ'>".
                            "</a>".
                        "<!--Конец группировка кнопок в navbar с выравниванием вправо закрыть печать и редактировать-->";                    
                    echo $buttons_edit_print;
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
            </div><!--/.my_box_content -->
        </div><!--/.my_box -->
    </div><!--my_usercard_content_block -->
</div>

