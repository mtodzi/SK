<?php

namespace backend\modules\stock\models;

use Yii;
use yii\base\Model;
use backend\modules\stock\models\Stocks;
use backend\modules\stock\models\ChangesTables;

class StocksEdit extends Model{
    
    //Задаем константы сценарияев для обработки форм
    const SCENARIO_CREATE = 'create';//Сценарий обрабатывает добавление склада
    const SCENARIO_UPDATE = 'update';//Сценарий обрабатывает добавление склада
    
    public $id_stocks;
    public $name_stock;
    
    /**
     * @inheritdoc
     * Увязываем поля со сценариями
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['name_stock'],
            self::SCENARIO_UPDATE => ['name_stock','id_stocks'],
        ];
    }
    
    public function rules(){
        return [
            [['id_stocks'], 'required'],
            [['id_stocks'], 'integer'],
            
            [['name_stock'], 'required'],
            [['name_stock'], 'string', 'max' => 255],            
        ];           
    }
    
    
    
    /*
     *Метод  сохраняет Stock  
     */
    public function saveStock(){
        $modelStock = new Stocks();
        $modelStock->name_stock = $this->name_stock;
        if($modelStock->save()){
            $modelChangesTables = new ChangesTables('stocks',$modelStock->id_stocks,'Был создан новый склад - '.$modelStock->name_stock, Yii::$app->user->identity->id);
            $modelChangesTables->save();
            return $modelStock;
        }else{
            return null;
        }        
    }
    
    /*
     *Метод  сохраняет Stock  
     */
    public function updateStock(){
        $modelStock = Stocks::findOne($this->id_stocks);
        if($modelStock!==null){
            $name_stock = $modelStock->name_stock;
            $modelStock->name_stock = $this->name_stock;
            if($modelStock->save()){
                $modelChangesTables = new ChangesTables('stocks',$modelStock->id_stocks,'Было изменено название склада было - '.$name_stock.' стало - '.$modelStock->name_stock, Yii::$app->user->identity->id);
                $modelChangesTables->save();
                return $modelStock;                
            }else{
                return null;
            }
        }else{
            return null;
        }    
    }
    
    //Метод возврашает русские лейбы полей обьекта
    public function attributeLabels() {
        return
        [
            'id_stocks'=>'Ключ склада',
            'name_stock'=>'Название склада',            
        ];
    }
}
