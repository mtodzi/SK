<?php

use yii\widgets\ListView;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\stock\assets\MyStocksAsset;

MyStocksAsset::register($this);

$this->title = Yii::t('app','Склады');
?>

<div class='my_heders_bloc row-flex sticky-top'>
    <nav class='navbar navbar-light bg-light border rounded'>
        <a class='navbar-brand' href='<?=Url::to(['/stock'])?>'>Склады</a>
        <div class='btn-group'>
            <!--кнопка добавить новый склад-->
            <div class="mx-1">
                <a  id = 'btn_create_new_stock' class="btn btn-dark" href="#" data-toggle="tooltip" data-placement="top" title="Добавить новый склад">
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/add.svg'])?>' alt="Добавить новый склад">
                </a>
            </div>
        </div>
        <!--Начало выбора склада-->
            <form method="get" action="<?=Url::to(['/stock'])?>">
                <select name="id" onChange="history(window.location='<?=Url::to(['/stock'])?>?id='+this.value);" >
                    <?php
                        foreach ($StocksModel as $data){
                            echo "<option value='".$data->id_stocks."'";
                            if($id == $data->id_stocks){
                                echo   " selected>";
                            }else{
                                echo   " >";
                            }    
                            echo   $data->name_stock."</option>";
                        }
                    ?>
                </select>
            </form>
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
                    <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/add.svg'])?>' alt="Добавить устройство на склад">
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



<!--Начало модального окна-->
<div class='modal' id='modal_create_new_stock' tabindex='-1' role='dialog'>
    <div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title'></h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
            </div>
            <div class='modal-body'>

            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Закрыть</button>                   
            </div>
        </div>
    </div>
</div>
<!--Конец модального окна-->