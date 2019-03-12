<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\orders\models\OrdersClamedMalfunction;
use backend\modules\orders\models\ClaimedMalfunction;

$phonestr = "";

if($model != null){
    $OrdersClamedMalfunction = OrdersClamedMalfunction::findAll(['orders_id'=>$model->id_orders]);
    $count = count($OrdersClamedMalfunction);
    $i=1;
    foreach ($OrdersClamedMalfunction as $malfunction){
        $phonestr = $phonestr."".
        "<div id = 'div_orders_malfunction-".$model->id_orders."-".$i."'class='div_orders_malfunction-".$model->id_orders."'>        
            <p id='p_orders_malfunction-".$model->id_orders."-".$i."' class='form-row my-2 orders_malfunction-".$model->id_orders." orders_malfunction'>
                <input id='input_orders_malfunction-".$model->id_orders."-".$i."' name='MalfunctionEdit[malfunction-".$i."]' data-input-name = 'malfunction' value='".$malfunction->claimedMalfunction->claimed_malfunction_name."'  form='' class='input_orders form-control col-8 malfunction_input malfunction_input-".$i."' type='text' placeholder='Заявленная неисправность'>";       
                if($count>1){
                    $phonestr = $phonestr."".
                    "<a  id = 'delete_another_malfunction-".$model->id_orders."-".$i."' class='btn btn-dark delete_another_malfunction mx-1'  data-count-malfunction='".$count."' data-toggle='tooltip' data-placement='right' title='Удалить заявленную неисправность'>".
                        "<img id ='menu_navbar_top' class='' src='/yii-application/backend/web/m_orders/img/minus.svg' alt='Удалить заявленную неисправность'>".
                    "</a>";
                }
                $phonestr = $phonestr."". 
                "<p id = 'error_orders_malfunction-".$model->id_orders."-".$i."' class='text-danger my-2 mx-2 error_orders_malfunction error_orders_malfunction-".$i."' style='display: none;'>Ошибка</p>                             
            </p>".Html :: hiddenInput('MalfunctionEdit[claimed_malfunction_id-'.$i.']', $malfunction->claimed_malfunction_id, ['id'=>('orders_claimed_malfunction_id-'.$model->id_orders.'-'.$i)]).
        "</div>";                               
        $i++;
    }
    $phonestr = $phonestr."".
    "<p class='form-row my-2'>
        <a id ='add_another_malfunction-".$model->id_orders."' class='btn btn-dark add_another_malfunction mx-1' data-count-malfunction='".$count."' data-toggle='tooltip' data-placement='right' title='Добавить еще заявленную неисправность'>
            <img id ='menu_navbar_top' class='' src='".Url::to(['/img/add.svg'])."' alt='Добавить еще заявленную неисправность'>
        </a>
    </p>";            
}else{
    $phonestr = $phonestr."".
        "<div id = 'div_orders_malfunction-0-1'class='div_orders_malfunction-0'>        
            <p id='p_orders_malfunction-0-1' class='form-row my-2 orders_malfunction-0 orders_malfunction'>
                <input id='input_orders_malfunction-0-1' name='MalfunctionEdit[malfunction-0]' data-input-name = 'malfunction' value=''  form='' class='input_orders form-control col-8 malfunction_input malfunction_input-0' type='text' placeholder='Заявленная неисправность'>       
                <p id = 'error_orders_malfunction-0-1' class='text-danger my-2 mx-2 error_orders_malfunction error_orders_malfunction-0' style='display: none;'>Ошибка</p>                             
            </p>".Html :: hiddenInput('MalfunctionEdit[claimed_malfunction_id-1]', 0, ['id'=>'orders_claimed_malfunction_id-0-0']).
        "</div>                       
        <p class='form-row my-2'>
            <a id ='add_another_malfunction-0' class='btn btn-dark add_another_malfunction mx-1' data-count-malfunction='1' data-toggle='tooltip' data-placement='right' title='Добавить еще заявленную неисправность'>
                <img id ='menu_navbar_top' class='' src='".Url::to(['/img/add.svg'])."' alt='Добавить еще заявленную неисправность'>
            </a>
        </p>";
}
echo $phonestr;
?>
