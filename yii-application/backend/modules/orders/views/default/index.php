<?php

use yii\widgets\ListView;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\orders\assets\MyOrdersAsset;

MyOrdersAsset::register($this);

$this->title = Yii::t('app','Заказы');
?>

<div class='my_heders_bloc row-flex sticky-top'>
    <nav class='navbar navbar-light bg-light border rounded'>
        <a class='navbar-brand' href='<?=Url::to(['/user/user/update'])?>'>Заказы</a>
        <div class='btn-group'>
            <div class='scroll_to_up'>
                <!--кнопка вверх scrollspy-->            
                <a  id = '' class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="В начало">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/arrow-up.svg'])?>' alt="В начало">
                </a>
            </div>
            <div class="mx-1">
                <!--кнопка архив заказов-->            
                <a  id = 'browse_archive_orders' class="btn btn-dark" href="<?=Url::to(['/orders'])?>" data-toggle="tooltip" data-placement="top" title="Смотреть архив заказов">
                <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/addarch.svg'])?>' alt="Смотреть архив заказов">
                </a>
            </div>
            <!--кнопка добавить новый заказ-->
            <div class="">
                <a  id = 'add_new_orders' class="btn btn-dark" href="#" data-toggle="tooltip" data-placement="top" title="Добавить заказ">
                <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/add.svg'])?>' alt="Добавить заказ">
                </a>
            </div>
        </div>
        <form class='form-inline' post="GET" action="<?=Url::to(['/orders'])?>">
            <input name="UserSearch[search]" class='form-control mr-2 my-2' type='search' placeholder='Поиск' value="" aria-label='Search'>
            <button class='btn btn-outline-success my-2' type='submit'>Поиск</button>
        </form>
    </nav>
</div> <!-- ./my_heders_bloc -->

<!-- скрытая переменная открытой карточки -->
<input type="hidden" id="status_card" data-user-card="" name="status_card" value="0">
<!-- конец скрытой переменной открытой карточки -->

<div class='index_orders_bloc'>
    <div class='my_content_bloc'>        
        <div id="ordercard-0">
            <?= $this->render('orderscard', ['model' => null,]);?>
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
                'options'=> ['class' => 'wrapper'],
                'itemOptions' => ['class' => ''],
                'summary'=>FALSE,
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('orderscard', ['model' => $model,]);
                },
        ]);
     ?>    
        
    </div>
    <div class='my_footer_bloc co-12'>
    </div>
</div>

        
