<?php

use yii\db\Migration;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;

/**
 * Class m190212_124459_devices
 */
class m190212_124459_devices extends Migration
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
        
        $this->createTable('{{%devices}}', [
            'id_devices' => $this->primaryKey(),
            'brands_id' => $this->integer(),
            'devices_type_id' => $this->integer(),
            'devices_model' => $this->string(255)->notNull(),
        ], $tableOptions);
        
        $this->createIndex('I_brands_id', 'devices', 'brands_id');
        $this->createIndex('I_devices_type_id', 'devices', 'devices_type_id');
        $this->addForeignKey('FK_brands_id', 'devices','brands_id','brands','id_brands','SET NULL','CASCADE');
        $this->addForeignKey('FK_devices_type_id', 'devices','devices_type_id','device_type','id_device_type','SET NULL','CASCADE');
    
        //добавляем некоторое количество тестовых пользователей
        for($i=1; $i<=30; $i++){
            $this->insert('{{%devices}}',['id_devices' => $i,
                                   'brands_id' => random_int(1,29),
                                   'devices_type_id' => random_int(1,29),
                                   'devices_model' => "Модель устройства-".$i,
                                   ]);
            
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_brands_id', 'devices');
        $this->dropForeignKey('FK_devices_type_id', 'devices');
        $this->dropIndex('I_brands_id', 'devices');
        $this->dropIndex('I_devices_type_id', 'devices');
        $this->dropTable('devices');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190212_124459_devices cannot be reverted.\n";

        return false;
    }
    */
}
