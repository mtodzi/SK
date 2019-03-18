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
    
    //Метод возврашает русские лейбы полей обьекта
    public function attributeLabels() {
        return
        [
            'id_brands'=>'Ключ Бренда',
            'name_brands'=>'Бренд',            
        ];
    }
}
