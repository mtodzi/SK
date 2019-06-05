<?php
//print_r($model_clients) ;

switch ($data_input_name){
    case 'name_brands':
        $select = "<select id='search_input_name_brands-".$id_serial_numbers."' size=3 name='' form='' class='select_name_brands'>";
        foreach ($model as $data){        
            $select = $select."<option class='option_name_brands input_serial_numbers_option' data-input-name = 'name_brands' id='option_name_brands-".$data->id_brands."' value = '".$data->id_brands."'>".$data->name_brands."</option>";   
        }
        $select = $select."</select>";                
        break;
    case 'device_type_name':
        $select = "<select id='search_input_device_type_name-".$id_serial_numbers."' size=3 name='' form='' class='select_device_type_name'>";
        foreach ($model as $data){        
            $select = $select."<option class='option_device_type_name input_serial_numbers_option' data-input-name = 'device_type_name' id='option_device_type_name-".$data->id_device_type."' value = '".$data->id_device_type."'>".$data->device_type_name."</option>";   
        }
        $select = $select."</select>";                
        break;  
    case 'devices_model':
        $select = "<select id='search_input_devices_model-".$id_serial_numbers."' size=3 name='' form='' class='select_devices_model'>";
        foreach ($model as $data){        
            $select = $select."<option class='option_devices_model input_serial_numbers_option' "
                    ."data-id_brands='".$data->brands->id_brands."' "
                    ."data-brand_name='".$data->brands->name_brands."' "
                    ."data-id_device_type='".$data->devicesType->id_device_type."' "
                    ."data-device_type_name='".$data->devicesType->device_type_name."' "
                    . "data-input-name = 'devices_model' id='option_devices_model-".$data->id_devices."' value = '".$data->id_devices."'>".$data->devices_model."</option>";   
        }
        $select = $select."</select>";                
        break;
    case 'serial_numbers_name':
        $select = "<select id='search_input_serial_numbers_name-".$id_serial_numbers."".(($type_addition!=0)?"-".$type_addition:"")."' size=3 name='' form='' class='select_devices_model'>";
        foreach ($model as $data){        
            $select = $select."<option class='option_serial_numbers_name input_serial_numbers_option' "
                    ."data-id_brands='".$data->devise->brands->id_brands."' "
                    ."data-brand_name='".$data->devise->brands->name_brands."' "
                    ."data-id_device_type='".$data->devise->devicesType->id_device_type."' "
                    ."data-device_type_name='".$data->devise->devicesType->device_type_name."' "
                    ."data-id_devices='".$data->devise->id_devices."' "
                    ."data-devices_model='".$data->devise->devices_model."' "
                    ."data-input-name = 'serial_numbers_name' id='option_serial_numbers_name-".$data->id_serial_numbers."' value = '".$data->id_serial_numbers."'>".$data->serial_numbers_name."</option>";   
        }
        $select = $select."</select>";                
        break;    
}

echo $select;