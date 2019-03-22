<?php

namespace backend\modules\orders\models;

use yii\base\Model;

class BrandsEdit extends Model{
    public $id_brands;
    public $brand_name;
    
    public function rules(){
        return [
            [['id_brands'], 'required'],
            [['id_brands'], 'integer'],
            
            [['brand_name'], 'required'],
            [['brand_name'], 'string', 'max' => 45],            
        ];           
    }
    
    //Метод возврашает русские лейбы полей обьекта
    public function attributeLabels() {
        return
        [
            'id_brands'=>'Ключ Бренда',
            'brand_name'=>'Бренд',            
        ];
    }
}
