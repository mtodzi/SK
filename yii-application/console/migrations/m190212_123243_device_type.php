<?php

use yii\db\Migration;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;
/**
 * Class m190212_123243_device_type
 */
class m190212_123243_device_type extends Migration
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
        
        $this->createTable('{{%device_type}}', [
            'id_device_type' => $this->primaryKey(),
            'device_type_name' => $this->string(255)->notNull(),
            
        ], $tableOptions);
        
        //добавляем некоторое количество тестовых пользователей
        for($i=1; $i<=30; $i++){
            $this->insert('{{%device_type}}',['id_device_type' => $i,
                                   'device_type_name' => 'Тип устройства-'.$i,
                                   ]);
            
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
          $this->dropTable('device_type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190212_123243_device_type cannot be reverted.\n";

        return false;
    }
    */
}
