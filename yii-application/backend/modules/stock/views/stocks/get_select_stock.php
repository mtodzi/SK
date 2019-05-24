<?php
use yii\helpers\Url;
?>

<form id="form_select_stock" method="get" action="<?=Url::to(['/stock'])?>">
    <select id="select_stock" name="id" onChange="window.location='<?=Url::to(['/stock'])?>?id='+this.value;" >
    <?php
        foreach ($StocksModel as $data){
            echo "<option id='select_option_stock-".$data->id_stocks."' value='".$data->id_stocks."'";
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