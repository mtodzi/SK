<?php

use yii\db\Migration;

/**
 * Class m190422_075355_addRolleOrders
 */
class m190422_075355_addRolleOrders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%controler}}',['id' => '7',
                                        'name_controler' => 'default',
                                        'alias_controler' => 'Заказы',
                                        'description' => 'Контроллер работы с заказами']);
        $this->insert('{{%action_ct}}',['id' => '29',
                                        'action_name' => 'index',
                                        'alias_action' => 'Заказы',
                                        'description' => 'Метод выводить открытые заказы на страницу, обеспечивает поиск и серфинг',
                                        'id_controler' => '7']);
        $this->insert('{{%action_ct}}',['id' => '30',
                                        'action_name' => 'archive',
                                        'alias_action' => 'Закрытые заказы',
                                        'description' => 'Метод выводить закрытые заказы на страницу, обеспечивает поиск и серфинг',
                                        'id_controler' => '7']);
        $this->insert('{{%action_ct}}',['id' => '31',
                                        'action_name' => 'create',
                                        'alias_action' => 'Добавить или редактировать',
                                        'description' => 'Метод добавляет и редактирует заказ',
                                        'id_controler' => '7']);
        $this->insert('{{%action_ct}}',['id' => '32',
                                        'action_name' => 'closeorder',
                                        'alias_action' => 'Закрыть заказ',
                                        'description' => 'Метод закрывает заказ',
                                        'id_controler' => '7']);
        $this->insert('{{%action_ct}}',['id' => '33',
                                        'action_name' => 'openorder',
                                        'alias_action' => 'Открыть заказ',
                                        'description' => 'Метод открывает заказ',
                                        'id_controler' => '7']);
        $this->insert('{{%action_ct}}',['id' => '34',
                                        'action_name' => 'takenameclient',
                                        'alias_action' => 'Выборка по клиентам',
                                        'description' => 'Метод дает подсказку  по ФИО клиента в заказе',
                                        'id_controler' => '7']);
        $this->insert('{{%action_ct}}',['id' => '35',
                                        'action_name' => 'takenamebrands',
                                        'alias_action' => 'Выборка по Бренду',
                                        'description' => 'Метод возвращает список брендов для поля Бренд заказов',
                                        'id_controler' => '7']);
        $this->insert('{{%action_ct}}',['id' => '36',
                                        'action_name' => 'takephonenumber',
                                        'alias_action' => 'Выборка по телефону',
                                        'description' => 'Метод возвращает список телефонов для поля телефон клиента в заказе',
                                        'id_controler' => '7']);
        $this->insert('{{%action_ct}}',['id' => '37',
                                        'action_name' => 'takeemailclient',
                                        'alias_action' => 'Выборка по почте',
                                        'description' => 'Метод возвращает список ящиков для поля почта клиента в заказе',
                                        'id_controler' => '7']);
        $this->insert('{{%action_ct}}',['id' => '38',
                                        'action_name' => 'takedevicetype',
                                        'alias_action' => 'Выборка по типу устройства',
                                        'description' => 'Метод возвращает список  типа устройств для поля в заказе',
                                        'id_controler' => '7']);
        $this->insert('{{%action_ct}}',['id' => '39',
                                        'action_name' => 'takedevicemodel',
                                        'alias_action' => 'Выборка по модели устройства',
                                        'description' => 'Метод возвращает список моделей для поля в заказе',
                                        'id_controler' => '7']);
        $this->insert('{{%action_ct}}',['id' => '40',
                                        'action_name' => 'takeserialnumbersname',
                                        'alias_action' => 'Выборка по серийному номеру',
                                        'description' => 'Метод возвращает список устройств по серийному номеру для поля в заказе',
                                        'id_controler' => '7']);
        $this->insert('{{%action_ct}}',['id' => '41',
                                        'action_name' => 'takeclient',
                                        'alias_action' => 'Выбранный клиент',
                                        'description' => 'Метод возвращает выбранного клиента из подсказки для заказа',
                                        'id_controler' => '7']);
        $this->insert('{{%action_ct}}',['id' => '42',
                                        'action_name' => 'takebrend',
                                        'alias_action' => 'Выбранный Бренд',
                                        'description' => 'Метод возвращает выбранный бренд из подсказки для заказа',
                                        'id_controler' => '7']);
        $this->insert('{{%action_ct}}',['id' => '43',
                                        'action_name' => 'takedevicet',
                                        'alias_action' => 'Выбранный тип устройства',
                                        'description' => 'Метод возвращает выбранный туп устройства из подсказки для заказа',
                                        'id_controler' => '7']);
        $this->insert('{{%action_ct}}',['id' => '44',
                                        'action_name' => 'takedevices',
                                        'alias_action' => 'Выбранная модель устройства',
                                        'description' => 'Метод возвращает модель устройства из подсказки для заказа',
                                        'id_controler' => '7']);
        $this->insert('{{%action_ct}}',['id' => '45',
                                        'action_name' => 'takeserialnumbers',
                                        'alias_action' => 'Выбранный серийный номер',
                                        'description' => 'Метод возвращает серийный номер из подсказки для заказа',
                                        'id_controler' => '7']);
        $this->insert('{{%action_ct}}',['id' => '46',
                                        'action_name' => 'takeclaimedmalfunction',
                                        'alias_action' => 'Выбранная заявленная неисправность',
                                        'description' => 'Метод возвращает заявленную неисправность из подсказки для заказа',
                                        'id_controler' => '7']);
        
        $this->insert('{{%acsess}}',['id' => '87', 'item_name' => 'admin', 'id_action_ct' => '29','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '88', 'item_name' => 'admin', 'id_action_ct' => '30','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '89', 'item_name' => 'admin', 'id_action_ct' => '31','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '90', 'item_name' => 'admin', 'id_action_ct' => '32','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '91', 'item_name' => 'admin', 'id_action_ct' => '33','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '92', 'item_name' => 'admin', 'id_action_ct' => '34','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '93', 'item_name' => 'admin', 'id_action_ct' => '35','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '94', 'item_name' => 'admin', 'id_action_ct' => '36','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '95', 'item_name' => 'admin', 'id_action_ct' => '37','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '96', 'item_name' => 'admin', 'id_action_ct' => '38','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '97', 'item_name' => 'admin', 'id_action_ct' => '39','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '98', 'item_name' => 'admin', 'id_action_ct' => '40','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '99', 'item_name' => 'admin', 'id_action_ct' => '41','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '100', 'item_name' => 'admin', 'id_action_ct' => '42','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '101', 'item_name' => 'admin', 'id_action_ct' => '43','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '102', 'item_name' => 'admin', 'id_action_ct' => '44','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '103', 'item_name' => 'admin', 'id_action_ct' => '45','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '104', 'item_name' => 'admin', 'id_action_ct' => '46','rows' => 1]);
        
        $this->insert('{{%acsess}}',['id' => '105', 'item_name' => 'manager', 'id_action_ct' => '29','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '106', 'item_name' => 'manager', 'id_action_ct' => '30','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '107', 'item_name' => 'manager', 'id_action_ct' => '31','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '108', 'item_name' => 'manager', 'id_action_ct' => '32','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '109', 'item_name' => 'manager', 'id_action_ct' => '33','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '110', 'item_name' => 'manager', 'id_action_ct' => '34','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '111', 'item_name' => 'manager', 'id_action_ct' => '35','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '112', 'item_name' => 'manager', 'id_action_ct' => '36','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '113', 'item_name' => 'manager', 'id_action_ct' => '37','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '114', 'item_name' => 'manager', 'id_action_ct' => '38','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '115', 'item_name' => 'manager', 'id_action_ct' => '39','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '116', 'item_name' => 'manager', 'id_action_ct' => '40','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '117', 'item_name' => 'manager', 'id_action_ct' => '41','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '118', 'item_name' => 'manager', 'id_action_ct' => '42','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '119', 'item_name' => 'manager', 'id_action_ct' => '43','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '120', 'item_name' => 'manager', 'id_action_ct' => '44','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '121', 'item_name' => 'manager', 'id_action_ct' => '45','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '122', 'item_name' => 'manager', 'id_action_ct' => '46','rows' => 0]);
        
        $this->insert('{{%acsess}}',['id' => '123', 'item_name' => 'engineer', 'id_action_ct' => '29','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '124', 'item_name' => 'engineer', 'id_action_ct' => '30','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '125', 'item_name' => 'engineer', 'id_action_ct' => '31','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '126', 'item_name' => 'engineer', 'id_action_ct' => '32','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '127', 'item_name' => 'engineer', 'id_action_ct' => '33','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '128', 'item_name' => 'engineer', 'id_action_ct' => '34','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '129', 'item_name' => 'engineer', 'id_action_ct' => '35','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '130', 'item_name' => 'engineer', 'id_action_ct' => '36','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '131', 'item_name' => 'engineer', 'id_action_ct' => '37','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '132', 'item_name' => 'engineer', 'id_action_ct' => '38','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '133', 'item_name' => 'engineer', 'id_action_ct' => '39','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '134', 'item_name' => 'engineer', 'id_action_ct' => '40','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '135', 'item_name' => 'engineer', 'id_action_ct' => '41','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '136', 'item_name' => 'engineer', 'id_action_ct' => '42','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '137', 'item_name' => 'engineer', 'id_action_ct' => '43','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '138', 'item_name' => 'engineer', 'id_action_ct' => '44','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '139', 'item_name' => 'engineer', 'id_action_ct' => '45','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '140', 'item_name' => 'engineer', 'id_action_ct' => '46','rows' => 0]);
        
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
        echo "m190422_075355_addRolleOrders cannot be reverted.\n";

        return false;
    }
    */
}
