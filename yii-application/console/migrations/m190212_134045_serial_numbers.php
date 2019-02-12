<?php

use yii\db\Migration;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;
/**
 * Class m190212_134045_serial_numbers
 */
class m190212_134045_serial_numbers extends Migration
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
        
        $this->createTable('{{%serial_numbers}}', [
            'id_serial_numbers' => $this->primaryKey(),
            'serial_numbers_name' => $this->string(255)->notNull(),
            'devise_id' => $this->integer(),           
        ], $tableOptions);
        
        $this->createIndex('I_devise_id', 'serial_numbers', 'devise_id');
        $this->addForeignKey('FK_devise_id', 'serial_numbers','devise_id','devices','id_devices','NO ACTION','CASCADE');
        
        //добавляем некоторое количество тестовых пользователей
        for($i=1; $i<=30; $i++){
            $this->insert('{{%serial_numbers}}',['id_serial_numbers' => $i,
                                   'serial_numbers_name' => "Серийный номер-".$i,
                                   'devise_id' => random_int(1,29),                                   
                                   ]);
            
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_devise_id', 'serial_numbers');
        $this->dropIndex('I_devise_id', 'serial_numbers');
        $this->dropTable('serial_numbers');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190212_134045_serial_numbers cannot be reverted.\n";

        return false;
    }
    */
}
