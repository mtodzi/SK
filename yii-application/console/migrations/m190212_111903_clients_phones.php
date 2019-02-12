<?php

use yii\db\Migration;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;
/**
 * Class m190212_111903_clients_phones
 */
class m190212_111903_clients_phones extends Migration
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
        
        $this->createTable('{{%clients_phones}}', [
            'clients_id' => $this->integer()->notNull(),
            'phone_number'=> $this->string(16)->notNull(),
            
        ], $tableOptions);
        
        $this->createIndex('I_clients_id', 'clients_phones', 'clients_id');
        $this->addForeignKey('FK_clients_id', 'clients_phones','clients_id','clients','id_clients','NO ACTION','CASCADE'); 
    
        //добавляем некоторое количество тестовых пользователей
        for($i=1; $i<=30; $i++){
            $this->insert('{{%clients}}',['id_clients' => $i,
                                   'clients_name' => 'Клиентов Клиент Клиентович-'.$i,
                                   'clients_email' => 'customer-'.$i.'@com.com',
                                   'clients_address' => 'ул Клиента дом '.$i.' квартира'.($i+1),
                                   'clients_archive' => 0,
                                   'created_at' => time(),
                                   'updated_at' => time(),]);
            $v=random_int(1,2);
            for($j=0; $j<=$v; $j++){
                $this->insert('{{%clients_phones}}',[
                                        'clients_id' => $i,
                                        'phone_number' => '8(066)-184-21-'.($i+$j+10),
                ]);
            }   
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_clients_id', 'clients_phones');
        $this->dropIndex('I_clients_id', 'clients_phones');
        $this->dropTable('clients_phones');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190212_111903_clients_phones cannot be reverted.\n";

        return false;
    }
    */
}
