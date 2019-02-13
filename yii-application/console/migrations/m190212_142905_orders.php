<?php

use yii\db\Migration;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;

/**
 * Class m190212_142905_orders
 */
class m190212_142905_orders extends Migration
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
        
        $this->createTable('{{%orders}}', [
            'id_orders' => $this->primaryKey(),
            'clients_id' => $this->integer(),//клиент
            'serrial_nambers_id' => $this->integer(),//устройство
            'repair_type' => $this->integer(1)->notNull(),
            'urgency' => $this->integer(1)->notNull(),
            'claimed_malfunction_id' => $this->integer(),//
            'user_engener_id' => $this->integer(),
            'user_manager_id' => $this->integer(),
            'archive' => $this->integer(1)->notNull(),
            'appearance' => $this->string(255)->notNull(),
            'special_notes' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        
        $this->createIndex('I_clients_id', 'orders', 'clients_id');
        $this->createIndex('I_serrial_nambers_id', 'orders', 'serrial_nambers_id');
        $this->createIndex('I_claimed_malfunction_id', 'orders', 'claimed_malfunction_id');
        $this->createIndex('I_user_engener_id', 'orders', 'user_engener_id');
        $this->createIndex('I_user_manager_id', 'orders', 'user_manager_id');
        
        $this->addForeignKey('FK_orders_clients_id', 'orders','clients_id','clients','id_clients','NO ACTION','CASCADE');
        $this->addForeignKey('FK_serrial_nambers_id', 'orders','serrial_nambers_id','serial_numbers','id_serial_numbers','NO ACTION','CASCADE');
        $this->addForeignKey('FK_claimed_malfunction_id', 'orders','claimed_malfunction_id','claimed_malfunction','id_claimed_malfunction','NO ACTION','CASCADE');
        $this->addForeignKey('FK_user_engener_id', 'orders','user_engener_id','user','id','NO ACTION','CASCADE');
        $this->addForeignKey('FK_user_manager_id', 'orders','user_manager_id','user','id','NO ACTION','CASCADE');
        
        //добавляем некоторое количество тестовых пользователей
        for($i=1; $i<=30; $i++){
            $this->insert('{{%orders}}',['id_orders' => $i,
                                   'clients_id' => random_int(1,29),
                                   'serrial_nambers_id' => random_int(1,29),
                                   'repair_type' => random_int(0,2),
                                   'urgency' => random_int(0,1),
                                   'claimed_malfunction_id' => random_int(1,29),
                                   'user_engener_id' => 12,
                                   'user_manager_id' => 30,
                                   'archive' => 0,
                                   'appearance' => 'Внешний вид-'.$i,
                                   'special_notes' => 'Особые заметки-'.$i,
                                   'created_at' => time(),
                                   'updated_at' => time(),
                                   ]);
            
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
  
        $this->dropForeignKey('FK_orders_clients_id', 'orders');
        $this->dropForeignKey('FK_serrial_nambers_id', 'orders');
        $this->dropForeignKey('FK_claimed_malfunction_id', 'orders');
        $this->dropForeignKey('FK_user_engener_id', 'orders');
        $this->dropForeignKey('FK_user_manager_id', 'orders');
        
        $this->dropIndex('I_clients_id', 'orders');
        $this->dropIndex('I_serrial_nambers_id', 'orders');
        $this->dropIndex('I_claimed_malfunction_id', 'orders');
        $this->dropIndex('I_user_engener_id', 'orders');
        $this->dropIndex('I_user_manager_id', 'orders');
        
        $this->dropTable('orders');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190212_142905_orders cannot be reverted.\n";

        return false;
    }
    */
}
