<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<!--Карточка заказа --> 
<div id='Block_add_serialnumbers-<?=(($model!=null)?$model->serialNumber->id_serial_numbers:0)?>' class="row-flex col-lg-6 offset-lg-3" <?=(($model==null)?("style='display: none;'"):'')?>>
    <div class="my_serialnumbers_content_block my-1 mx-1">
        <div class="my_box">
            <!--Начало Хедера карточки-->
            <div class = "my_box_heder">
               <nav class="navbar navbar-light bg-dark rounded-top">
                    <span id='span_serialnumbers_id_serial_numbers-<?=(($model!=null)?$model->serialNumber->id_serial_numbers:0)?>' class='navbar-brand text-light'><?=(($model!=null)?'Карточка продукта на складе':'Добавить продукт на склад')?></span>
                    <?php
                    $buttons_edit_delete = "".   
                    "<!--группировка кнопок в navbar с выравниванием вправо редактировать продукт и удалить продукт со склада-->".
                        "<div id='stock_card_button_edit_delete-".(($model!=null)?$model->serialNumber->id_serial_numbers:0)."' class='flex-box ml-auto'>". 
                        "<!--кнопка редоктировать продукт который на складе-->".
                            "<a id='serialnambers_edit_button-".(($model!=null)?$model->serialNumber->id_serial_numbers:0)."' class='nav-link btn btn-light serialnambers_edit_button' data-toggle='tooltip' data-placement='left' title='Редактировать продукт'>".
                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/edit.svg'])."' alt='Редактировать продукт'>".
                            "</a>".
                        "<!--конец кнопки продукт который на складе-->".    
                        "<!--кнопка удалить продукт со склада-->".
                            "<a id='serialnambers_delete_button-".(($model!=null)?$model->serialNumber->id_serial_numbers:0)."' class='nav-link btn btn-light mx-1 serialnambers_delete_button' data-toggle='tooltip' data-placement='right' title='Удалить продукт со склада'>".
                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/m_stocks/img/no-photos-light.svg'])."' alt='Удалить продукт со склада'>".
                            "</a>".
                        "<!--конец кнопка удалить продукт со склада-->".    
                        "</div>".
                    "<!--Конец группировка кнопок в navbar с выравниванием вправо редактировать продукт и удалить продукт со склада-->";
                    $buttons_card_apply = "".
                    "<!--группировка кнопок в navbar с выравниванием вправо пременить отмена-->".
                        "<div id='serialnambers_cancel_button_card_apply-".(($model!=null)?$model->serialNumber->id_serial_numbers:0)."' class='flex-box ml-auto' ".(($model!=null)?("style='display: none;'"):'')."'>". 
                            "<!--кнопка отменить изменения и вернуться-->".
                            "<a id='serialnambers_cancel_button-".(($model!=null)?$model->serialNumber->id_serial_numbers:0)."' class='nav-link btn btn-light mx-1 serialnambers_cancel_button' data-toggle='tooltip' data-placement='left' title='Отмена'>".
                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/abort.svg'])."' alt='Отмена'>".
                            "</a>".
                            "<!--кнопка применить изменения-->".
                            "<a id='serialnambers_apply_button-".(($model!=null)?$model->serialNumber->id_serial_numbers:0)."' class='nav-link btn btn-light serialnambers_apply_button' data-toggle='tooltip' data-placement='right' title='Применить'>".
                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/accept.svg'])."' alt='Применить'>".
                            "</a>".
                        "</div>".
                    "<!--Конец группировка кнопок в navbar с выравниванием вправо пременить отмена-->";
                    if(($model!=null)){
                        echo $buttons_edit_delete;
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
                        echo $this->render('viewserialnambers', ['model' => $model,]);
                    }                
                ?>
                <!-- Конец Информации заказа -->
                <!-- Блок редактирования заказа-->
                <div id = 'serialnumbers_form-<?=(($model!=null)?$model->serialNumber->id_serial_numbers:0)?>' <?=(($model!=null)?("style='display: none;'"):'')?> >
                    <div class='col py-2'>
                        <div class=''>
                            <form id='form_serialnambers_stock-<?=(($model!=null)?$model->serialNumber->id_serial_numbers:0)?>' name='form_serialnambers_stock-<?=(($model!=null)?$model->serialNumber->id_serial_numbers:0)?>'>
                                <?=Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), [])?>
                                <?=Html :: hiddenInput('EquipmentStockEdit[stock_id]', (($model!=null)?$model->stock_id:0), ['id'=>'input_equipment_stock_stock_id-'.(($model!=null)?$model->serialNumber->id_serial_numbers:0)])?>
                                <?=Html :: hiddenInput('EquipmentStockEdit[serial_number_id]', (($model!=null)?$model->serial_number_id:0), ['id'=>'input_equipment_stock_serial_number_id-'.(($model!=null)?$model->serialNumber->id_serial_numbers:0)])?>
                            </form>
                            <div id = "div_serialnambers_name_brands-<?=(($model!=null)?$model->serialNumber->id_serial_numbers:0)?>">
                                <p class="form-row my-2"> 
                                    <input id='input_serialnambers_brand_name-<?=(($model!=null)?$model->serialNumber->id_serial_numbers:0)?>' 
                                        name='BrandsEdit[brand_name]' data-input-name = "name_brands"  form='form_serialnambers_stock-<?=(($model!=null)?$model->serialNumber->id_serial_numbers:0)?>' 
                                        class="form-control col-4 mx-2 input_serialnambers_brand_name input_serialnambers"
                                        value="<?=(($model!=null)?$model->serialNumber->devise->brands->name_brands:'')?>"
                                        type="text" placeholder="Бренд">
                                    <?php $id = 'serialnambers_id_brands-'.(($model!=null)?$model->serialNumber->id_serial_numbers:0);?>
                                    <?=Html :: hiddenInput('BrandsEdit[id_brands]', (($model!=null)?$model->serialNumber->devise->brands->name_brands:0), ['id'=>$id, 'form'=>'form_serialnambers_stock-'.(($model!=null)?$model->serialNumber->id_serial_numbers:0)])?>
                                </p>
                                <p id = 'error_serialnambers_brand_name-<?=(($model!=null)?$model->serialNumber->id_serial_numbers:0)?>' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                            </div>
                        </div>
                    </div>        
                </div>
                <!--Конец Блок редактирования заказа-->
            </div><!--/.my_box_content -->
        </div><!--/.my_box -->
    </div><!--my_usercard_content_block -->
</div>

