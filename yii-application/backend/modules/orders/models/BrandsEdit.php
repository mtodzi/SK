<?php

namespace backend\modules\orders\models;

use yii\base\Model;

class BrandsEdit extends Model{
    public $id_brands;
    public $name_brands;
    
    public function rules(){
        return [
            [['id_brands'], 'required'],
            [['id_brands'], 'integer'],
            
            [['name_brands'], 'required'],
            [['name_brands'], 'string', 'max' => 45],            
        ];           
    }
}
