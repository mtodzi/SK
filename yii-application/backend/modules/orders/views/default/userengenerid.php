<?php
    use yii\helpers\Html;
    use common\models\User;
    
    $str = "<option ".(($model!=null)?'':'selected')." value='0'>Назначить исполнителя</option>";
    $model_user_engener = User::findAll(['id_position'=>3]);
    foreach ($model_user_engener as $data){
        $str = $str."<option ".((($model!=null)&&($model->user_engener_id == $data->id))?'selected':'')." value='".$data->id."'>".$data->employeename."</option>";
    }
?>
<p class="form-row my-2">
    <select id='input_orders_user_engener_id-<?=(($model!=null)?$model->id_orders:0)?>' form='form_orders-<?=(($model!=null)?$model->id_orders:0)?>' name='OrdersEdit[user_engener_id]' class="form-control col-6 mx-2"> 
        <?=$str?>
    </select>    
</p>
<p id = 'error_orders_user_engener_id-<?=(($model!=null)?$model->id_orders:0)?>' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>
<p>
    Менеджер принимающий заказ: <span id = 'orders_user_manager-<?=(($model!=null)?$model->id_orders:0)?>'><?=(($model!=null)?$model->userManager->employeename:Yii::$app->user->identity->employeename)?></span>
</p>
