<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>


<div class='modal' id='modal_create_new_stock' tabindex='-1' role='dialog'>
    <div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title'>Добавить новый склад</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
            </div>
            <div class='modal-body'>
                <!--Начало формы добавления нового склада-->
                <form id='form_new_stock'>
                    <?=Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), [])?>
                    <div id = 'div_input_name_stock'>
                        <p id = 'p_input_name_stock' class='form-row my-2'>
                            <img class='my_icon mx-1 my-2' src='<?=Url::to(['/img/orders/thumb/client.svg'])?>'>
                            <input id='input_name_stock' name='StocksEdit[name_stock]' data-input-name = "name_stock" value='' class='input_stocks form-control col-10 input_name_stock' type='name' placeholder='*Введите название склада'>
                            <?=Html :: hiddenInput('StocksEdit[id_stocks]','', ['id'=>'input_id_stocks'])?>
                            <p id = 'error_name_stock' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
                        </p>
                    </div>
                </form>
                <!-- Конец формы добавления нового склада -->
            </div>
            <div class='modal-footer'>
                <button id='button_new_update_stocks' type='button' data-position='' class='btn btn-secondary'>New</button> 
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Закрыть</button>                   
            </div>
        </div>
    </div>
</div>
