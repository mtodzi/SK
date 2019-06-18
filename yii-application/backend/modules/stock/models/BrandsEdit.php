<?php

namespace backend\modules\stock\models;

use Yii;
use yii\base\Model;
use backend\modules\stock\models\Brands;
use backend\modules\stock\models\ChangesTables;

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
    
    /*
     *Метод  сохраняет Бренд и возврашает его id для сохранения в devise 
     */
    public function saveBrand(){
        if($this->id_brands == 0){
            $modelBrand = new Brands();
            $modelBrand->name_brands = $this->brand_name;
            if($modelBrand->save()){
                $modelChangesTables = new ChangesTables('brands',$modelBrand->id_brands,'Был создан новый бренд при добавлении продукта на склад - '.$modelBrand->name_brands, Yii::$app->user->identity->id);
                $modelChangesTables->save();
                return array('errror'=>0,'msg'=>$modelBrand);
            }else{
                return array('errror'=>1,'msg'=>'По неизвестной причине новый бренд при добавление нового продукта на склад не был создан');
            }
        }else{
            $i = 0; //количество измененых полей в клиенте
            $modelChangesBrand = 0;
            $modelBrand = Brands::findOne($this->id_brands);
            if($modelBrand!==null){
                if(strcmp($modelBrand->name_brands , $this->brand_name)!== 0){
                    $i++;
                    $nameBrands = $modelBrand->name_brands;
                    $modelBrand->name_brands = $this->brand_name;
                    $modelChangesBrand = new ChangesTables('brands',$modelBrand->id_brands,'При работе со складом  был изменено имя бренда было - '.$nameBrands.'стало - '.$this->brand_name, Yii::$app->user->identity->id);
                }
                if($i!=0){
                    if($modelBrand->save()){
                        if(!empty($modelChangesBrand)){
                            $modelChangesBrand->save();
                        }
                        return array('errror'=>0,'msg'=>$modelBrand);
                    }else{
                        return array('errror'=>1,'msg'=>'По неизвестной причине новый бренд при добавление нового продукта на склад не был изменен');
                    }
                }else{
                    return array('errror'=>0,'msg'=>$modelBrand);
                }
            }else{
                return array('errror'=>1,'msg'=>'По неизвестной причине новый бренд не был найден в БД');
            }
        }
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
