<?php

use yii\widgets\ListView;
use yii\helpers\Url;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//$this->registerCssFile('@web/fuser/css/user.css');

$this->title = Yii::t('app', 'Персонал');

?>
<div class='index_user_bloc row'>
    <div class='my_heders_bloc col-xl-9 col-lg-9 col-md-11 col-sm-11 col-8'>
        <nav class='navbar navbar-light bg-light'>

            <a class='navbar-brand' href='<?=Url::to(['/user/user/indexarchive'])?>'>Архив персонала</a>
            <form class='form-inline' post="GET" action="<?=Url::to(['/user/user/indexarchive'])?>">
                <input name="UserSearch[search]" value="<?=$searchModel->search?>" class='form-control mr-2 my-2' type='search' placeholder='Поиск' aria-label='Search'>            
                <button class='btn btn-outline-success my-2' type='submit'>Поиск</button>
            </form>
        </nav>
    </div>
    <input type="hidden" id="status_card" data-user-card="" name="status_card" value="0">
    <div class='my_content_bloc col-10'>        
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
                        "<div class='col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12  my-1' id='user_bloc_kard-".$model->id."'>".
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
                                        "<div class='col-10 col-xl-2 col-md-2'>".
                                            "<!--фото сотрудника-->".
                                            "<img class='user_photo bg-secondary mx-2' src='".$model->getUrlMiniature()."'class='align-self-start mr-3' alt='фото сотрудника'>".
                                        "</div>".
                                        "<div id='user_data-".$model->id."' class='px-4 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12' >".                
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
        