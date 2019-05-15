<?php

use yii\db\Migration;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;

/**
 * Class m190515_141740_equipment_showcase
 */
class m190515_141740_equipment_showcase extends Migration
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
        
        $this->createTable('{{%equipment_showcase}}', [
            'showcase_id' => $this->integer()->notNull(),
            'devices_id' => $this->integer()->notNull(),
            
        ], $tableOptions);
        
        $this->createIndex('I_showcase_id', 'equipment_showcase', 'showcase_id');
        $this->createIndex('I_devices_id', 'equipment_showcase', 'devices_id');
        $this->addForeignKey('FK_showcase_id', 'equipment_showcase','showcase_id','showcases','id_showcase','CASCADE','CASCADE');
        $this->addForeignKey('FK_devices_id', 'equipment_showcase','devices_id','devices','id_devices','CASCADE','CASCADE');
        
        //добавляем некоторое количество тестовых пользователей
        for($i=1; $i<=15; $i++){
            $this->insert('{{equipment_showcase}}',['showcase_id' => 1,
                                   'devices_id' => $i,                                  
                                   ]);
            
        }
        for($i=16; $i<=29; $i++){
            $this->insert('{{equipment_showcase}}',['showcase_id' => 2,
                                   'devices_id' => $i,                                  
                                   ]);
            
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_showcase_id', 'equipment_showcase');
        $this->dropForeignKey('FK_serial_number_id', 'equipment_showcase');
        $this->dropIndex('I_devices_id', 'equipment_showcase');
        $this->dropIndex('I_showcase_id', 'equipment_showcase');
        $this->dropTable('equipment_showcase');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190515_141740_equipment_showcase cannot be reverted.\n";

        return false;
    }
    */
}
