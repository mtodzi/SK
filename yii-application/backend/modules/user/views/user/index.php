<?php

use yii\widgets\ListView;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\user\assets\MyUsersAsset;
use backend\modules\user\assets\AssetKartikFileInput;

AssetKartikFileInput::register($this);
MyUsersAsset::register($this);

$this->title = Yii::t('app', 'Персонал');


?>
<div class='index_user_bloc row'>
    <div class='my_heders_bloc sticky-top mx-auto col-12'>
        <nav class='navbar navbar-light bg-light border rounded'>
            <a class='navbar-brand' href='<?=Url::to(['/user/user/update'])?>'>Персонал</a>
            <div class="d-flex justify-content-start col-xl-5 col-lg-4 col-md-4 col-sm-9 col-10"> 
                <div>
                <!--кнопка архив сотрудников-->            
                <a  id = 'browse_archive' class="btn btn-dark mx-1" href="<?=Url::to(['/user/user/indexarchive'])?>" data-toggle="tooltip" data-placement="top" title="Смотреть архив сотрудников">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/addarch.svg'])?>' alt="Смотреть архив сотрудников">
                </a>
                </div>
                <!--кнопка добавить сотрудника-->
                <div class="ml-auto">
                <a  id = 'add_new_user' class="btn btn-dark mx-1" href="#" data-toggle="tooltip" data-placement="top" title="Добавить сотрудника">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/add.svg'])?>' alt="Добавить сотрудника">
                </a>
                </div>
                    
            </div>
            <form class='form-inline' post="GET" action="<?=Url::to(['/user/user/index'])?>">
                <input name="UserSearch[search]" class='form-control mr-2 my-2' type='search' placeholder='Поиск' value="<?=$searchModel->search?>" aria-label='Search'>
                <button class='btn btn-outline-success my-2' type='submit'>Поиск</button>
            </form>
        </nav>
    </div>
    <input type="hidden" id="status_card" data-user-card="" name="status_card" value="0">
    <div class='my_content_bloc col-10'>        
        <!-- пустая карточка --> 
        <div id='Block_add_user' class="row" style='display: none;'>
            <div class="my_usercard_content_block col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12  my-1 mx-auto">
                <div class="my_box">
                    <div class = "my_box_heder">
                        <nav class="navbar navbar-light bg-dark rounded-top">
                            <span class="navbar-brand text-light">Карточка сотрудника</span>
                            
                            <!--группировка кнопок в navbar с выравниванием вправо-->
                                <div class="btn-group ml-auto"> 
                                <!--кнопка отменить изменения и вернуться-->
                                    <a id='user_cancel_button-0' class="nav-link btn btn-light mx-1 user_cancel_button" data-toggle="tooltip" data-placement="left" title="Отмена">
                                        <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/abort.svg'])?>' alt="Отмена">
                                    </a>
                                <!--кнопка применить изменения-->
                                    <a  id='apply_add_new_user-0' class="nav-link btn btn-light user_apply_button" data-toggle="tooltip" data-placement="right" title="Применить">
                                        <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/accept.svg'])?>' alt="Применить">
                                    </a>
                                </div>
                        
                        </nav>
                    </div>             
                    <div class="my_box_content rounded-bottom bg-light border border-top-0 border-dark">
                        <div class="row py-2">
                            <div class="col-10 col-xl-2 col-md-2">
                                <img id='user_img_photo-0' class="user_photo bg-secondary mx-2" src="<?=Url::to(['/users/img/users/default/default.svg'])?>" class="align-self-start mr-3" alt="...">
                                <!--Начало модального окна-->
                                <div class='modal' id='modal_update_photo_user-0' tabindex='-1' role='dialog'>
                                    <div class='modal-dialog' role='document'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title'>Фото сотрудника</h5>
                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                    <span aria-hidden='true'>&times;</span>
                                                </button>
                                            </div>
                                            <div class='modal-body'>
                                                <p>Хотите добавить фото</p>
                                                <input name='UserPhoto[photo]' id='input_photo_update-0' type='file' form='form-update_user-0'>
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Закрыть</button>                   
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Конец модального окна-->
                                <div id='block_button_photo_edit-0' class='col-10 col-xl-2 col-md-2'>
                                <!--кнопка редактировать фото-->
                                <a id='user_photo_edit_button-0' class='btn btn-dark mx-3 my-1 btn-update-photo' data-toggle='tooltip' data-placement='bottom' title='Добавить фото'>
                                    <img id ='menu_navbar_top' class='' src='<?=Url::to(['/img/change_photo.svg'])?>' alt='Добавить фото'>
                                </a> 
                                </div>
                            </div>
                                <div class="px-4 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">
                                    <form id='form-update_user-0'>
                                        <?= Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), [])?>
                                    </form>
                                    <div id='user_alert_server-0' class='alert alert-danger' role='alert' style='display: none;'>
                                        <span id='span_user_alert_server-0'>Ошибка</span>
                                    </div>
                                    <h5><p class="form-row my-2 mx-2"> 
                                        <input id='input_user_employeename-0' name='UserEdit[employeename]'  form='form-update_user-0' class="form-control col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12" type="text" placeholder="Введите ФИО нового сотрудника"> - 
                                            <select id='input_user_id_position-0' form='form-update_user-0' name='UserEdit[id_position]' class="form-control col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"> 
                                                <option selected value='0'>выберите должность</option>
                                                <option value='3'>инженер</option>
                                                <option value='2'>менеджер</option>
                                                <option value='1'>директор</option>
                                            </select>
                                    </p>
                                    </h5>    
                                    <p id = 'error_user_employeename-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                    <p id = 'error_user_id_position-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                    
                                    <p class="form-row my-2"><img class="my_icon mx-1 my-2" src="<?=Url::to(['/img/mail.svg'])?>"> <input id='input_user_email-0' name='UserEdit[email]' form='form-update_user-0' class="form-control col-10" type="mail" placeholder="Введите адрес электронной почты"> </p>
                                    <p id = 'error_user_email-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                    <p class="form-row my-2"><img class="my_icon mx-1 my-2" src="<?=Url::to(['/img/smartphone-call.svg'])?>"> <input id='input_user_phone-0' name='UserEdit[phone]'  form='form-update_user-0' class="form-control col-10 phone" type="text" placeholder="Введите номер телефона"></p>
                                    <p id = 'error_user_phone-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                    <p class="form-row my-2"><img class="my_icon mx-1 my-2" src="<?=Url::to(['/img/home.svg'])?>"> <input id='input_user_address-0' name='UserEdit[address]' form='form-update_user-0' class="form-control col-10" type="text" placeholder="Введите домашний адрес"> </p>
                                    <p id = 'error_user_address-0' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                                    <p class='form-row my-2 mx-4'> <input id='input_user_password-0' name='UserEdit[password]' form='form-update_user-0' class='form-control col-6' type='password' placeholder='Задайте пароль'> </p>
                                    <p id = 'error_user_password-0' class='text-danger my-2' style='display: none;'>Ошибка</p>
                                    <p class='form-row my-2 mx-4'> <input id='input_user_prePassword-0' name='UserEdit[prePassword]' form='form-update_user-0' class='form-control col-6' type='password' placeholder='Введите пароль повторно'> </p>
                                    <p id = 'error_user_prePassword-0' class='text-danger my-2' style='display: none;'>Ошибка</p>
                                </div>
                        
                        </div>    
                    </div>
                </div>
            </div>
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
                'options'=> ['class' => ''],
                'itemOptions' => ['class' => 'row'],
                'summary'=>FALSE,
                'itemView' => function ($model, $key, $index, $widget) {
                    $position = backend\modules\user\models\Position::find()->all();
                    $select = "<select name='UserEdit[id_position]' form='form-update_user-".$model->id."' class='form-control col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12'>";
                    foreach ($position as $data){
                        if($data->id != $model->id_position){
                            $select = $select."<option id='option_select_".$data->name_position."-".$model->id."' value = '".$data->id."'>".$data->name_position."</option>";  
                        }else{
                            $select = $select."<option selected id='option_select_".$data->name_position."-".$model->id."' value = '".$data->id."'>".$data->name_position."</option>";
                        }
                    }
                    $select = $select."</select>";  
                    $bloc = "".                           
                        "<div class='my_usercard_content_block col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12  my-1 mx-auto' id='user_bloc_kard-".$model->id."'>".
                            "<!--Форма для отправки пользователя в Архив-->".
                            "<form id='form_archive_user-".$model->id."'>".
                                Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), []).
                                Html :: hiddenInput('UserArchive[id]', $model->id, []).
                                Html :: hiddenInput('UserArchive[archive]', $model->archive, ['id'=>'user_archive_val-'.$model->id]).
                            "</form>".
                            "<!--Конец формы для отправки пользователя в Архив-->". 
                            "<form id='form-update_user-".$model->id."'>".
                            Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), []).
                            Html :: hiddenInput('UserEdit[id]', $model->id, []).
                            "</form>".
                            "<div id='user_box-".$model->id."' class='my_box userbox'>".
                                "<div class = 'my_box_heder'>".
                                    "<nav class='navbar navbar-light bg-dark rounded-top'>".
                                        "<span class='navbar-brand text-light'>Карточка сотрудника</span>".
                                        "<div id='user_card_button_edit_archive-".$model->id."' class='flex-box ml-auto'>". 
                                            "<!--кнопка добавить в архив сотрудника-->".
                                            "<a id='user_archive_button-".$model->id."' class='nav-link btn btn-light mx-1 user_archive_button' data-toggle='tooltip' data-placement='left' title='Отправить в архив'>".
                                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/addarch.svg'])."' alt='Отправить в архив'>".
                                            "</a>".
                                            "<!--кнопка редактировать сотрудника-->".
                                            "<a id='user_edit_button-".$model->id."' class='nav-link btn btn-light user_edit_button' data-toggle='tooltip' data-placement='right' title='Редактировать'>".
                                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/edit.svg'])."' alt='Применить'>".
                                            "</a>".
                                        "</div>".
                                        "<!--группировка кнопок в navbar с выравниванием вправо-->".
                                        "<div id='user_cancel_button_card_apply-".$model->id."' class='flex-box ml-auto' style='display: none;'>". 
                                            "<!--кнопка отменить изменения и вернуться-->".
                                            "<a id='user_cancel_button-".$model->id."' class='nav-link btn btn-light mx-1 user_cancel_button' data-toggle='tooltip' data-placement='left' title='Отмена'>".
                                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/abort.svg'])."' alt='Отмена'>".
                                            "</a>".
                                            "<!--кнопка применить изменения-->".
                                            "<a id='user_apply_button-".$model->id."' class='nav-link btn btn-light user_apply_button' data-toggle='tooltip' data-placement='right' title='Применить'>".
                                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/accept.svg'])."' alt='Применить'>".
                                            "</a>".
                                        "</div>".
                                    "</nav>".
                                "</div>".             
                                "<div class='my_box_content rounded-bottom bg-light border border-top-0 border-dark'>".
                                    "<div class='row py-2'>".                                       
                                        "<div class='col-10 col-xl-2 col-md-2'>".
                                            "<!--фото сотрудника-->".
                                            "<img id='user_img_photo-".$model->id."' class='user_photo bg-secondary mx-2' src='".$model->getUrlMiniature()."'class='align-self-start mr-3' alt='фото сотрудника'>".
                                            "<!--Начало модального окна-->".
                                            "<div class='modal' id='modal_update_photo_user-".$model->id."' tabindex='-1' role='dialog'>".
                                                "<div class='modal-dialog' role='document'>".
                                                    "<div class='modal-content'>".
                                                        "<div class='modal-header'>".
                                                            "<h5 class='modal-title'>Фото сотрудника  - ".$model->employeename."</h5>".
                                                            "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>".
                                                                "<span aria-hidden='true'>&times;</span>".
                                                            "</button>".
                                                        "</div>".
                                                        "<div class='modal-body'>".
                                                            "<p>Хотите изменит фото</p>".
                                                            "<input name='UserPhoto[photo]' id='input_photo_update-".$model->id."' type='file'>".
                                                        "</div>".
                                                        "<div class='modal-footer'>".
                                                            "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Закрыть</button>".                   
                                                        "</div>".
                                                    "</div>".
                                                "</div>".
                                            "</div>".
                                            "<!--Конец модального окна-->".
                                            "<div id='block_button_photo_edit-".$model->id."' class='col-10 col-xl-2 col-md-2' style='display: none;'>".
                                                "<!--кнопка редактировать фото-->".
                                                "<a id='user_photo_edit_button-".$model->id."' class='btn btn-dark mx-3 my-1 btn-update-photo' data-toggle='tooltip' data-placement='bottom' title='Изменить фото'>".
                                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/change_photo.svg'])."' alt='Изменить фото'>".
                                                "</a>". 
                                            "</div>".
                                        "</div>".
                                        "<div id='user_data-".$model->id."' class='px-4 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12' >".                
                                            "<h5 class='mt-0'><span id='span_user_employeename-".$model->id."' >".$model->employeename."</span> - <span id='span_user_name_position-".$model->id."'>".$model->position->name_position."</span></h5>".
                                            "<p class='p_margin0'><img class='my_icon' src='".Url::to(['/img/mail.svg'])."'><span id='span_user_email-".$model->id."'>".$model->email."</span></p>".
                                            "<p class='p_margin0'><img class='my_icon' src='".Url::to(['/img/smartphone-call.svg'])."'><span id='span_user_phone-".$model->id."'>".$model->phone."</span></p>".
                                            "<p class='p_margin0'><img class='my_icon' src='".Url::to(['/img/home.svg'])."'><span id='span_user_address-".$model->id."'>".$model->address."</span></p>".
                                        "</div>".                                   
                                        "<div id='user_data_edit-".$model->id."' class='px-4 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12' style='display: none;'>".
                                            "<div id='user_alert_server-".$model->id."' class='alert alert-danger' role='alert' style='display: none;'>".
                                                "<span id='span_user_alert_server-".$model->id."'>Ошибка</span>".               
                                            "</div>".
                                            "<h5><p class='form-row my-2 mx-2'> <input id='input_user_employeename-".$model->id."' name='UserEdit[employeename]' form='form-update_user-".$model->id."' class='form-control col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12' type='text' value='".$model->employeename."'> - ".
                                            $select.
                                            "</p>".
                                            "</h5>".
                                            "<p id = 'error_user_employeename-".$model->id."' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>".
                                            "<p id = 'error_user_id_position-".$model->id."' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>".
                                            "<p class='form-row my-2'><img class='my_icon mx-1 my-2' src='".Url::to(['/img/mail.svg'])."'> <input id='input_user_email-".$model->id."' name='UserEdit[email]' form='form-update_user-".$model->id."' class='form-control col-10' type='mail' value='".$model->email."'> </p>".
                                            "<p id = 'error_user_email-".$model->id."' class='text-danger my-2' style='display: none;'>Ошибка</p>".
                                            "<p class='form-row my-2'><img class='my_icon mx-1 my-2' src='".Url::to(['/img/smartphone-call.svg'])."'> <input id='input_user_phone-".$model->id."' name='UserEdit[phone]' form='form-update_user-".$model->id."' class='form-control col-10  phone' type='text' value='".$model->phone."'></p>".
                                            "<p id = 'error_user_phone-".$model->id."' class='text-danger my-2' style='display: none;'>Ошибка</p>".
                                            "<p class='form-row my-2'><img class='my_icon mx-1 my-2' src='".Url::to(['/img/home.svg'])."'> <input id='input_user_address-".$model->id."' name='UserEdit[address]' form='form-update_user-".$model->id."' class='form-control col-10' type='text' value='".$model->address."'> </p>".
                                            "<p id = 'error_user_address-".$model->id."' class='text-danger my-2' style='display: none;'>Ошибка</p>".
                                            "<div class='form-check mx-4'> ".
                                                    "<input class='form-check-input'  type='checkbox' id='check_user_pass_change-".$model->id."'>".
                                                    "<input class='form-check-input' name='check_user_pass_change' form='form-update_user-".$model->id."' value='0' type='hidden' id='check_user_pass_change_hidden-".$model->id."'>".
                                                    "<label class='form-check-label' for='defaultCheck1'> сменить пароль </label> ".
                                            "</div>".
                                            "<div class='mx-4' id='user_change_pass_block-".$model->id."' style='display: none;'>".
                                                "<p class='form-row my-2'> <input id='input_user_password-".$model->id."' name='UserEdit[password]' form='form-update_user-".$model->id."' class='form-control col-6' type='password' placeholder='Задайте пароль'> </p>".
                                                "<p id = 'error_user_password-".$model->id."' class='text-danger my-2' style='display: none;'>Ошибка</p>".
                                                "<p class='form-row my-2'> <input id='input_user_prePassword-".$model->id."' name='UserEdit[prePassword]' form='form-update_user-".$model->id."' class='form-control col-6' type='password' placeholder='Введите пароль повторно'> </p>".
                                                "<p id = 'error_user_prePassword-".$model->id."' class='text-danger my-2' style='display: none;'>Ошибка</p>".
                                            "</div>".
                                        "</div>".
                                    "</div>".    
                                "</div>".
                            "</div>".
                        "</div>";
                return $bloc;
            },
        ]);
     ?>       
    </div>
    <div class='my_footer_bloc co-12'>
    </div>
</div>
        