<?php

use yii\db\Migration;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;

/**
 * Class m190311_110620_orders_clamed_malfunction
 */
class m190311_110620_orders_clamed_malfunction extends Migration
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
        
        $this->createTable('{{%orders_clamed_malfunction}}', [
            'orders_id' => $this->integer()->notNull(),
            'claimed_malfunction_id' => $this->integer()->notNull(),
            
        ], $tableOptions);
        
        $this->createIndex('I_orders_id', 'orders', 'id_orders');
        $this->createIndex('I_claimed_malfunction_id', 'claimed_malfunction', 'id_claimed_malfunction');
        $this->addForeignKey('FK_orders_id', 'orders_clamed_malfunction','orders_id','orders','id_orders','CASCADE','CASCADE');
        $this->addForeignKey('FK_claimed_malfunction_id', 'orders_clamed_malfunction','claimed_malfunction_id','claimed_malfunction','id_claimed_malfunction','CASCADE','CASCADE');
        
        //добавляем некоторое количество тестовых пользователей
        for($i=1; $i<=30; $i++){
            $v=random_int(1,2);
            for($j=0; $j<=$v; $j++){
                $s=random_int(1,29);
                $this->insert('{{%orders_clamed_malfunction}}',[
                                        'orders_id' => $i,
                                        'claimed_malfunction_id' => $s,
                ]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_orders_id', 'orders_clamed_malfunction');
        $this->dropForeignKey('FK_claimed_malfunction_id', 'orders_clamed_malfunction');
        $this->dropIndex('I_orders_id', 'orders_clamed_malfunction');
        $this->dropIndex('I_claimed_malfunction_id', 'orders_clamed_malfunction');
        $this->dropTable('orders_clamed_malfunction');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190311_110620_orders_clamed_malfunction cannot be reverted.\n";

        return false;
    }
    */
}
