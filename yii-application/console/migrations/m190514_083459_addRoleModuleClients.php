<?php

use yii\db\Migration;

/**
 * Class m190514_083459_addRoleModuleClients
 */
class m190514_083459_addRoleModuleClients extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%controler}}',['id' => '8',
                                        'name_controler' => 'client',
                                        'alias_controler' => 'Клиенты',
                                        'description' => 'Контроллер для работы с клиентами']);
        $this->insert('{{%action_ct}}',['id' => '47',
                                        'action_name' => 'index',
                                        'alias_action' => 'Главная странница с клиентами',
                                        'description' => 'Метод показывает главную странницу с клиентами',
                                        'id_controler' => '8']);
        $this->insert('{{%action_ct}}',['id' => '48',
                                        'action_name' => 'сreate',
                                        'alias_action' => 'Добавление клиента',
                                        'description' => 'Метод добавляет нового клиента во вкладке клиенты',
                                        'id_controler' => '8']);
        $this->insert('{{%action_ct}}',['id' => '49',
                                        'action_name' => 'update',
                                        'alias_action' => 'Редактировать клиента',
                                        'description' => 'Метод позволяет редактировать клиента',
                                        'id_controler' => '8']);
        
        $this->insert('{{%acsess}}',['id' => '141', 'item_name' => 'admin', 'id_action_ct' => '47','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '142', 'item_name' => 'admin', 'id_action_ct' => '48','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '143', 'item_name' => 'admin', 'id_action_ct' => '49','rows' => 1]);
        
        $this->insert('{{%acsess}}',['id' => '144', 'item_name' => 'manager', 'id_action_ct' => '47','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '145', 'item_name' => 'manager', 'id_action_ct' => '48','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '146', 'item_name' => 'manager', 'id_action_ct' => '49','rows' => 0]);
        
        $this->insert('{{%acsess}}',['id' => '147', 'item_name' => 'engineer', 'id_action_ct' => '47','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '148', 'item_name' => 'engineer', 'id_action_ct' => '48','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '149', 'item_name' => 'engineer', 'id_action_ct' => '49','rows' => 0]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190514_083459_addRoleModuleClients cannot be reverted.\n";

        return false;
    }
    */
}
