<?php

use yii\db\Migration;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;

/**
 * Class m190212_120638_brands
 */
class m190212_120638_brands extends Migration
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
        
        $this->createTable('{{%brands}}', [
            'id_brands' => $this->primaryKey(),
            'name_brands' => $this->string(45)->notNull(),
            
        ], $tableOptions);
        //добавляем некоторое количество тестовых пользователей
        for($i=1; $i<=30; $i++){
            $this->insert('{{%brands}}',['id_brands' => $i,
                                   'name_brands' => 'Бренд-'.$i,
                                   ]);
            
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('brands');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190212_120638_brands cannot be reverted.\n";

        return false;
    }
    */
}
