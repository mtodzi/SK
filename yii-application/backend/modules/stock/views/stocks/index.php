<?php


use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\stock\assets\MyStocksAsset;

MyStocksAsset::register($this);

$this->title = Yii::t('app','Склады');
?>

<div class='my_heders_bloc row-flex sticky-top'>
    <nav class='navbar navbar-light bg-light border rounded'>
        <a class='navbar-brand' href='<?=Url::to(['/stock'])?>'>Склады</a>
        <div id ="btn_stock_group_update" class='btn-group'>
            <!--кнопка добавить новый склад-->
            <div class="mx-1">
                <a  id = 'btn_create_new_stock' class="btn btn-dark" href="#" data-toggle="tooltip" data-placement="top" title="Добавить новый склад">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/m_stocks/img/no-photos-light.svg'])?>' alt="Добавить новый склад">
                </a>
            </div>
            <div class="mx-1">
                <a  id = 'btn_update_new_stock' class="btn btn-dark" href="#" data-toggle="tooltip" data-placement="top" title="Отредактировать склад">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/m_stocks/img/no-photos-light.svg'])?>' alt="Отредактировать склад">
                </a>
            </div>
        </div>
        <!--Начало выбора склада-->
           <?= $this->render('get_select_stock', ['StocksModel' => $StocksModel,'id'=>$id])?>
        <!--Конец выбора склада-->
        <div class='btn-group'>
            <div class='scroll_to_up'>
                <!--кнопка вверх scrollspy-->            
                <a  id = '' class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="В начало">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/arrow-up.svg'])?>' alt="В начало">
                </a>
            </div>
            <!--кнопка добавить новый продукт на склад-->
            <div class="mx-1">
                <a  id = 'add_new_serialNambers_in_stock' class="btn btn-dark" href="#" data-toggle="tooltip" data-placement="top" title="Добавить устройство на склад">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/m_stocks/img/no-photos-light.svg'])?>' alt="Добавить устройство на склад">
                </a>
            </div>
        </div>
        <form class='form-inline' post="GET" action="<?=Url::to(['/stock'])?>">
            <input name="StocksSearch[search]" class='form-control mr-2 my-2' type='search' placeholder='Поиск' value="" aria-label='Search'>
            <button class='btn btn-outline-success my-2' type='submit'>Поиск</button>
        </form>
    </nav>
</div> <!-- ./my_heders_bloc -->

<!-- скрытая переменная открытой карточки -->
<input type="hidden" id="status_card" data-user-card="" name="status_card" value="0">
<!-- конец скрытой переменной открытой карточки -->

<!--Блок продуктов на выбранном складе-->
     <?= $this->render('serialnumbers_in_stock', ['dataProvider' => $dataProvider])?>
<!--Конец блока продуктов на выбранном складе-->





<!--Начало модального окна-->
    <?= $this->render('modal_stock')?>
<!--Конец модального окна-->