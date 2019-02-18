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
<div class='my_heders_bloc row-flex sticky-top'>
        <nav class='navbar navbar-light bg-light border rounded'>
            <a class='navbar-brand' href='<?=Url::to(['/user/user/indexarchive'])?>'>Архив персонала</a>
            
            <div class='btn-group'>
                <div class='scroll_to_up'>
                <!--кнопка вверх scrollspy-->            
                <a  id = '' class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="В начало">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/arrow-up.svg'])?>' alt="В начало">
                </a>
                </div>
            </div>      
            
            <form class='form-inline' post="GET" action="<?=Url::to(['/user/user/indexarchive'])?>">
                <input name="UserSearch[search]" value="<?=$searchModel->search?>" class='form-control mr-2 my-2' type='search' placeholder='Поиск' aria-label='Search'>            
                <button class='btn btn-outline-success my-2' type='submit'>Поиск</button>
            </form>
        
        </nav>
</div> <!-- /.my_heders_bloc-->
<!-- скрытая переменная открытой карточки -->
<input type="hidden" id="status_card" data-user-card="" name="status_card" value="0">
<!-- конец скрытой переменной открытой карточки -->

<div class='index_user_bloc'>
    <div class='my_content_bloc'>        
        <?php
            echo ListView::widget([
                'dataProvider' => $dataProvider,
                'pager' => [
                    'maxButtonCount' => 3,
                    // Customzing options for pager container tag
                    'options' => [
                        'tag' => 'ul',
                        'class'=>'pagination my-2'   
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
                        "<div class='my_usercard_content_block my-1 mx-1' id='user_bloc_kard-".$model->id."'>".
                            "<!--Форма для отправки пользователя в Архив-->".
                            "<form id='form_archive_user-".$model->id."'>".
                                Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), []).
                                Html :: hiddenInput('UserArchive[id]', $model->id, []).
                                Html :: hiddenInput('UserArchive[archive]', $model->archive, ['id'=>'user_archive_val-'.$model->id]).
                            "</form>".
                            "<!--Конец формы для отправки пользователя в Архив-->".
                            "<div id='user_box-".$model->id."' class='my_box userbox'>".
                                "<div class = 'my_box_heder'>".
                                    "<nav class='navbar navbar-light bg-dark rounded-top'>".
                                        "<span class='navbar-brand text-light'>Карточка сотрудника</span>".
                                        "<div id='user_card_button_edit_archive-".$model->id."' class='flex-box ml-auto'>". 
                                            "<!--кнопка вернуть из архива в сотрудники-->".
                                            "<a id='user_archive_button-".$model->id."' class='nav-link btn btn-light mx-1 user_archive_button' data-toggle='tooltip' data-placement='left' title='Восстановить из архива'>".
                                                "<img id ='menu_navbar_top' class='' src='".Url::to(['/img/recover_arch.svg'])."' alt='Восстановить из архива'>".
                                            "</a>".
                                        "</div>".
                                    "</nav>".
                                "</div>".             
                                "<div class='my_box_content rounded-bottom bg-light border border-top-0 border-dark'>".
                                    "<div class='row py-2'>".                                       
                                        "<div class='col-3'>".
                                            "<!--фото сотрудника-->".
                                            "<img class='user_photo bg-secondary mx-2' src='".$model->getUrlMiniature()."'class='align-self-start' alt='фото сотрудника'>".
                                        "</div>".
                                        "<div id='user_data-".$model->id."' class='col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12' >".                
                                            "<h5 class='mt-0'><span id='span_user_employeename-".$model->id."' >".$model->employeename."</span> - <span id='span_user_name_position-".$model->id."'>".$model->position->name_position."</span></h5>".
                                            "<p class='p_margin0'><img class='my_icon' src='".Url::to(['/img/mail.svg'])."'><span id='span_user_email-".$model->id."'>".$model->email."</span></p>".
                                            "<p class='p_margin0'><img class='my_icon' src='".Url::to(['/img/smartphone-call.svg'])."'><span id='span_user_phone-".$model->id."'>".$model->phone."</span></p>".
                                            "<p class='p_margin0'><img class='my_icon' src='".Url::to(['/img/home.svg'])."'><span id='span_user_address-".$model->id."'>".$model->address."</span></p>".
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
        