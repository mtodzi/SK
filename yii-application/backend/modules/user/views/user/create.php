<?php
use yii\helpers\Url;
use yii\helpers\Html;


$position = backend\modules\user\models\Position::find()->all();
$select = "<select name='UserEdit[id_position]' form='form-update_user-".$model->id."' class='form-control col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12'>";
foreach ($position as $data){
    if($data->id != $model->id_position){
        $select = $select."<option value = '".$data->id."'>".$data->name_position."</option>";  
    }else{
        $select = $select."<option selected value = '".$data->id."'>".$data->name_position."</option>";    
    }
}
$select = $select."</select>";  
$bloc = "".
    "<div class='row' data-key = ".$model->id.">".
        "<div class='col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12  my-1'>".
            "<form id='form-update_user-".$model->id."'>".
                Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), []).
                Html :: hiddenInput('UserEdit[id]', $model->id, []).
            "</form>".
            "<div id='user_box-".$model->id."' class='my_box userbox'>".
                "<div class = 'my_box_heder'>".
                    "<nav class='navbar navbar-light bg-dark rounded-top'>".
                        "<span class='navbar-brand text-light'>Карточка сотрудника</span>".
                        "<div id='user_card_button_edit_archive-".$model->id."' class='btn-group ml-auto'>". 
                        "<!--кнопка добавить в архив сотрудника-->".
                            "<a id='user_archive_button-".$model->id."' class='nav-link btn btn-light mx-1' data-toggle='tooltip' data-placement='left' title='В архив'>".
                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/addarch.svg'])."' alt='В архив'>".
                            "</a>".
                        "<!--кнопка редактировать сотрудника-->".
                            "<a id='user_edit_button-".$model->id."' class='nav-link btn btn-light user_edit_button' data-toggle='tooltip' data-placement='right' title='Редактировать'>".
                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/edit.svg'])."' alt='Применить'>".
                            "</a>".
                        "</div>".
                        "<!--группировка кнопок в navbar с выравниванием вправо-->".
                        "<div id='user_cancel_button_card_apply-".$model->id."' class='btn-group ml-auto' style='display: none;'>". 
                        "<!--кнопка отменить изменения и вернуться-->".
                            "<a id='user_cancel_button-".$model->id."' class='nav-link btn btn-light mx-1 user_cancel_button' data-toggle='tooltip' data-placement='left' title='Отмена'>".
                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/abort.svg'])."' alt='Отмена'>".
                            "</a>".
                        "<!--кнопка применить изменения-->".
                            "<a id='user_apply_button-".$model->id."' class='nav-link btn btn-light user_apply_button' dataser_butt-toggle='tooltip' data-placement='right' title='Применить'>".
                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/accept.svg'])."' alt='Применить'>".
                            "</a>".
                        "</div>".
                    "</nav>".
                "</div>".             
                "<div class='my_box_content rounded-bottom bg-light border border-top-0 border-dark'>".
                    "<div class='row py-2'>".                                       
                        "<div class='col-10 col-xl-2 col-md-2'>".
                            "<img class='user_photo bg-secondary mx-2' src='".Url::to(['/img/6170248_xlarge.jpg'])."' class='align-self-start mr-3' alt='...'>".
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
    "</div>".
"</div>";
echo $bloc;
?>
