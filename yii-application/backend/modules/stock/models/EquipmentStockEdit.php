<?php

namespace backend\modules\stock\models;

use Yii;
use yii\base\Model;
use backend\modules\stock\models\EquipmentStock;
use backend\modules\stock\models\ChangesTables;

class EquipmentStockEdit extends Model{
    
    public $stock_id;
    public $serial_number_id;
    
    const SCENARIO_EQUIPMENT_STOCK_ONE = 'equipment_stock_one';//Сценарий обрабатывает проверку по серийному номеру когда один номер
    const SCENARIO_EQUIPMENT_STOCK_RANGE = 'sereial_numbers_range';//Сценарий обрабатывает проверку по серийному номеру когда диопозон
    const SCENARIO_EQUIPMENT_STOCK_SOME = 'sereial_numbers_some';//Сценарий обрабатывает проверку по серийному номеру когда множество разных серийных номеров
    
    /**
     * @inheritdoc
     * Увязываем поля со сценариями
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_EQUIPMENT_STOCK_ONE => ['stock_id','serial_number_id'],
            self::SCENARIO_EQUIPMENT_STOCK_RANGE => ['stock_id'],
            self::SCENARIO_EQUIPMENT_STOCK_SOME => ['stock_id'],
        ];
    }
    
    public function rules()
    {
        return [
            [['stock_id'], 'required'],
            [['stock_id'], 'integer'],
            
            [['serial_number_id'], 'required'],
            [['serial_number_id'], 'integer'],
  
        ];
    }
    
    public function saveEquipmentStock(){
        $EquipmentStockModelinStoks = EquipmentStock::findOne([
                'serial_number_id' => $this->serial_number_id,
        ]);
        if($EquipmentStockModelinStoks != null ){
            return array('errror'=>1,'msg'=>('На '.($EquipmentStockModelinStoks->stock->name_stock).' уже есть добавляемый серийный номер - '.($EquipmentStockModelinStoks->serialNumber->serial_numbers_name)));
        }else{
            $EquipmentStockModel = new EquipmentStock();
            $EquipmentStockModel->stock_id = $this->stock_id;
            $EquipmentStockModel->serial_number_id = $this->serial_number_id;
            if($EquipmentStockModel->save()){
                $modelChangesTables = new ChangesTables('equipment_stock',$EquipmentStockModel->stock_id,'Был добавлен продукт с серийым номером - '.$EquipmentStockModel->serialNumber->serial_numbers_name, Yii::$app->user->identity->id);
                $modelChangesTables->save();
                return array('errror'=>0,'msg'=>$EquipmentStockModel);
            }else{
                return array('errror'=>1,'msg'=>'По неизвестной причине продукт не был помещен на склад обратитесь к админу');
            }
        }
    }
    
    public function saveEquipmentStockNewSirealNambers($sirealNambersModel){
        $EquipmentStockModelinStoks = EquipmentStock::findOne([
                'serial_number_id' => $this->serial_number_id,
        ]);
        if($EquipmentStockModelinStoks != null ){
            return array('errror'=>1,'msg'=>('На '.($EquipmentStockModelinStoks->stock->name_stock).' уже есть добавляемый серийный номер - '.($EquipmentStockModelinStoks->serialNumber->serial_numbers_name)));
        }else{
            $EquipmentStockModel = new EquipmentStock();
            $EquipmentStockModel->stock_id = $this->stock_id;
            $EquipmentStockModel->serial_number_id = $sirealNambersModel->id_serial_numbers;
            if($EquipmentStockModel->save()){
                $modelChangesTables = new ChangesTables('equipment_stock',$EquipmentStockModel->stock_id,'Был добавлен продукт с серийым номером - '.$EquipmentStockModel->serialNumber->serial_numbers_name, Yii::$app->user->identity->id);
                $modelChangesTables->save();
                return array('errror'=>0,'msg'=>$EquipmentStockModel);
            }else{
                return array('errror'=>1,'msg'=>'По неизвестной причине продукт не был помещен на склад обратитесь к админу');
            }
        }
    }

    public function attributeLabels() {
        return
            [
                'stock_id'=>'Ключ склада',
                'serial_number_id'=>'Ключ серийного номера',  
                
            ];
    }
    
}

