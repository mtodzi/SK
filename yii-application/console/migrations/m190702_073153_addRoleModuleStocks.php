<?php

use yii\db\Migration;

/**
 * Class m190702_073153_addRoleModuleStocks
 */
class m190702_073153_addRoleModuleStocks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%controler}}',['id' => '9',
                                        'name_controler' => 'stocks',
                                        'alias_controler' => 'Склады',
                                        'description' => 'Контроллер для работы со складами']);
        
        $this->insert('{{%action_ct}}',['id' => '50',
                                        'action_name' => 'index',
                                        'alias_action' => 'Склады',
                                        'description' => 'Главная страница со складами',
                                        'id_controler' => '9']);
        $this->insert('{{%action_ct}}',['id' => '51',
                                        'action_name' => 'createstock',
                                        'alias_action' => 'Добавить склад',
                                        'description' => 'Метод добавляет новый склад',
                                        'id_controler' => '9']);
        $this->insert('{{%action_ct}}',['id' => '52',
                                        'action_name' => 'updatestock',
                                        'alias_action' => 'Обновить склад',
                                        'description' => 'Метод обновляет названия выбранного склада',
                                        'id_controler' => '9']);
        $this->insert('{{%action_ct}}',['id' => '53',
                                        'action_name' => 'deleteproducktstock',
                                        'alias_action' => 'Удаляет продукт со склада',
                                        'description' => 'Метод удаляет продукт со склада',
                                        'id_controler' => '9']);
        $this->insert('{{%action_ct}}',['id' => '54',
                                        'action_name' => 'addserialnambersinstock',
                                        'alias_action' => 'Добавляем продукт на склад',
                                        'description' => 'Метод добавляет продукт на склад',
                                        'id_controler' => '9']);
        $this->insert('{{%action_ct}}',['id' => '55',
                                        'action_name' => 'taketxtinput',
                                        'alias_action' => 'Подсказка для поля ввода',
                                        'description' => 'Метод ищет подсказки в БД для полей ввода при добавлении продукта на склад',
                                        'id_controler' => '9']);
        $this->insert('{{%action_ct}}',['id' => '56',
                                        'action_name' => 'updateserialnamber',
                                        'alias_action' => 'Обновление данных продукта',
                                        'description' => 'Метод обновляет данные продукта который храниться на складе',
                                        'id_controler' => '9']);
        
        $this->insert('{{%acsess}}',['id' => '150', 'item_name' => 'admin', 'id_action_ct' => '50','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '151', 'item_name' => 'admin', 'id_action_ct' => '51','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '152', 'item_name' => 'admin', 'id_action_ct' => '52','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '153', 'item_name' => 'admin', 'id_action_ct' => '53','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '154', 'item_name' => 'admin', 'id_action_ct' => '54','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '155', 'item_name' => 'admin', 'id_action_ct' => '55','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '156', 'item_name' => 'admin', 'id_action_ct' => '56','rows' => 1]);
        
        $this->insert('{{%acsess}}',['id' => '157', 'item_name' => 'manager', 'id_action_ct' => '50','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '158', 'item_name' => 'manager', 'id_action_ct' => '51','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '159', 'item_name' => 'manager', 'id_action_ct' => '52','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '160', 'item_name' => 'manager', 'id_action_ct' => '53','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '161', 'item_name' => 'manager', 'id_action_ct' => '54','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '162', 'item_name' => 'manager', 'id_action_ct' => '55','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '163', 'item_name' => 'manager', 'id_action_ct' => '56','rows' => 0]);
        
         $this->insert('{{%acsess}}',['id' => '164', 'item_name' => 'engineer', 'id_action_ct' => '50','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '165', 'item_name' => 'engineer', 'id_action_ct' => '51','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '166', 'item_name' => 'engineer', 'id_action_ct' => '52','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '167', 'item_name' => 'engineer', 'id_action_ct' => '53','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '168', 'item_name' => 'engineer', 'id_action_ct' => '54','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '169', 'item_name' => 'engineer', 'id_action_ct' => '55','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '170', 'item_name' => 'engineer', 'id_action_ct' => '56','rows' => 0]);
        
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
        echo "m190702_073153_addRoleModuleStocks cannot be reverted.\n";

        return false;
    }
    */
}
