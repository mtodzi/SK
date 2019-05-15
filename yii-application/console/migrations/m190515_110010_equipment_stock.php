<?php

use yii\db\Migration;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;

/**
 * Class m190515_110010_equipment_stock
 */
class m190515_110010_equipment_stock extends Migration
{
    /**
     * @throws yii\base\InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }
        return $authManager;
    }
    
    /**
     * @return bool
     */
    protected function isMSSQL()
    {
        return $this->db->driverName === 'mssql' || $this->db->driverName === 'sqlsrv' || $this->db->driverName === 'dblib';
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;
        
        $this->createTable('{{%equipment_stock}}', [
            'stock_id' => $this->integer()->notNull(),
            'serial_number_id' => $this->integer()->notNull(),
            
        ], $tableOptions);
        
        $this->createIndex('I_stock_id', 'equipment_stock', 'stock_id');
        $this->createIndex('I_serial_number_id', 'equipment_stock', 'serial_number_id');
        $this->addForeignKey('FK_stock_id', 'equipment_stock','stock_id','stocks','id_stocks','CASCADE','CASCADE');
        $this->addForeignKey('FK_serial_number_id', 'equipment_stock','serial_number_id','serial_numbers','id_serial_numbers','CASCADE','CASCADE');
        
        //добавляем некоторое количество тестовых пользователей
        for($i=1; $i<=15; $i++){
            $this->insert('{{equipment_stock}}',['stock_id' => 1,
                                   'serial_number_id' => $i,                                  
                                   ]);
            
        }
        for($i=16; $i<=29; $i++){
            $this->insert('{{equipment_stock}}',['stock_id' => 2,
                                   'serial_number_id' => $i,                                  
                                   ]);
            
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_serial_number_id', 'equipment_stock');
        $this->dropForeignKey('FK_stock_id', 'equipment_stock');
        $this->dropIndex('I_serial_number_id', 'equipment_stock');
        $this->dropIndex('I_stock_id', 'equipment_stock');
        $this->dropTable('equipment_stock');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190515_110010_equipment_stock cannot be reverted.\n";

        return false;
    }
    */
}
