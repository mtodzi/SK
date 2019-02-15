<?php
print_r($model_clients) ;

$select = "<select name='' form='' class='form-control col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12'>";
    foreach ($model_clients as $data){        
        $select = $select."<option id='' value = ''>".$data->clients_name."</option>";   
    }
$select = $select."</select>";
echo $select;