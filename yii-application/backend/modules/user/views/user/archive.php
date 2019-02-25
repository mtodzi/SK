<?php

use yii\widgets\ListView;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\user\assets\MyUsersAsset;
use backend\modules\user\assets\AssetKartikFileInput;

AssetKartikFileInput::register($this);
MyUsersAsset::register($this);
$this->title = Yii::t('app', 'Персонал - архив');

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
                     return  $this->render('create', ['model' => $model,]);
                },
        ]);
     ?>       
    </div>
    <div class='my_footer_bloc co-12'>
    </div>
</div>
        