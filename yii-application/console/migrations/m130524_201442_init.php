<?php

use yii\db\Schema;
use yii\db\Migration;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;

class m130524_201442_init extends Migration
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
    
    public function up()
    {
        
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;
        $this->createTable('{{%position}}', [
            'id' => $this->primaryKey(),
            'name_position' => $this->string(255)->notNull()->unique(),
            'description_position' => $this->string()->null(),
        ], $tableOptions);
        
        $this->insert('{{%position}}',['id' => '1',
                                       'name_position' => 'Директор',
                                       'description_position'=>'NULL']);
        $this->insert('{{%position}}',['id' => '2',
                                       'name_position' => 'Менеджер',
                                       'description_position'=>'NULL']);
        $this->insert('{{%position}}',['id' => '3',
                                       'name_position' => 'Инженер',
                                       'description_position'=>'NULL']);
        
        
        $this->createTable($authManager->ruleTable, [
            'name' => $this->string(64)->notNull(),
            'data' => $this->binary(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY (name)',
        ], $tableOptions);

        $this->createTable($authManager->itemTable, [
            'name' => $this->string(64)->notNull(),
            'type' => $this->smallInteger()->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(64),
            'data' => $this->binary(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY (name)',
            'FOREIGN KEY (rule_name) REFERENCES ' . $authManager->ruleTable . ' (name)'.
                ($this->isMSSQL() ? '' : ' ON DELETE SET NULL ON UPDATE CASCADE'),
        ], $tableOptions);
        $this->createIndex('idx-auth_item-type', $authManager->itemTable, 'type');

        $this->createTable($authManager->itemChildTable, [
            'parent' => $this->string(64)->notNull(),
            'child' => $this->string(64)->notNull(),
            'PRIMARY KEY (parent, child)',
            'FOREIGN KEY (parent) REFERENCES ' . $authManager->itemTable . ' (name)'.
                ($this->isMSSQL() ? '' : ' ON DELETE CASCADE ON UPDATE CASCADE'),
            'FOREIGN KEY (child) REFERENCES ' . $authManager->itemTable . ' (name)'.
                ($this->isMSSQL() ? '' : ' ON DELETE CASCADE ON UPDATE CASCADE'),
        ], $tableOptions);

        $this->createTable($authManager->assignmentTable, [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->string(64)->notNull(),
            'created_at' => $this->integer(),
            'PRIMARY KEY (item_name, user_id)',
            'FOREIGN KEY (item_name) REFERENCES ' . $authManager->itemTable . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        if ($this->isMSSQL()) {
            $this->execute("CREATE TRIGGER dbo.trigger_auth_item_child
            ON dbo.{$authManager->itemTable}
            INSTEAD OF DELETE, UPDATE
            AS
            DECLARE @old_name VARCHAR (64) = (SELECT name FROM deleted)
            DECLARE @new_name VARCHAR (64) = (SELECT name FROM inserted)
            BEGIN
            IF COLUMNS_UPDATED() > 0
                BEGIN
                    IF @old_name <> @new_name
                    BEGIN
                        ALTER TABLE {$authManager->itemChildTable} NOCHECK CONSTRAINT FK__auth_item__child;
                        UPDATE {$authManager->itemChildTable} SET child = @new_name WHERE child = @old_name;
                    END
                UPDATE {$authManager->itemTable}
                SET name = (SELECT name FROM inserted),
                type = (SELECT type FROM inserted),
                description = (SELECT description FROM inserted),
                rule_name = (SELECT rule_name FROM inserted),
                data = (SELECT data FROM inserted),
                created_at = (SELECT created_at FROM inserted),
                updated_at = (SELECT updated_at FROM inserted)
                WHERE name IN (SELECT name FROM deleted)
                IF @old_name <> @new_name
                    BEGIN
                        ALTER TABLE {$authManager->itemChildTable} CHECK CONSTRAINT FK__auth_item__child;
                    END
                END
                ELSE
                    BEGIN
                        DELETE FROM dbo.{$authManager->itemChildTable} WHERE parent IN (SELECT name FROM deleted) OR child IN (SELECT name FROM deleted);
                        DELETE FROM dbo.{$authManager->itemTable} WHERE name IN (SELECT name FROM deleted);
                    END
            END;");
        }
        $this->insert($authManager->itemTable,[
                                        'name' => 'admin',
                                        'type' => 1,
                                        'description' => 'Роль самым большим доступом ко всем группам и их действиям.',
                                        //'rule_name' =>'',
                                        //'data' => '',
                                        'created_at' => time(),
                                        'updated_at' => time(),
                                        ]);
        $this->insert($authManager->itemTable,[
                                        'name' => 'engineer',
                                        'type' => 1,
                                        'description' => 'Роль инженера ',
                                        //'rule_name' =>'',
                                        //'data' => '',
                                        'created_at' => time(),
                                        'updated_at' => time(),
                                        ]);
        $this->insert($authManager->itemTable,[
                                        'name' => 'manager',
                                        'type' => 1,
                                        'description' => 'Роль менеджера',
                                        //'rule_name' =>'',
                                        //'data' => '',
                                        'created_at' => time(),
                                        'updated_at' => time(),
                                        ]);
        
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(), //id
            'auth_key' => $this->string(32)->notNull(),//ключ аунтификации
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'employeename' => $this->string()->notNull(),
            'phone'=> $this->string(16)->notNull(),
            'address' => $this->string()->notNull(),
            'id_position' => $this->integer(10)->defaultValue(null),   
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'archive'=> $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            "KEY id_controler (id_position)",
            "FOREIGN KEY (id_position) REFERENCES position (id) ON DELETE SET NULL ON UPDATE CASCADE",
        ], $tableOptions);
        
        $this->insert('{{%user}}',['id' => '1',
                                   'auth_key' => Yii::$app->security->generateRandomString(),
                                   'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
                                   'password_reset_token' => NULL,
                                   'email' => 'mtodzi@gmail.com',
                                   'employeename' => 'Морозов Андрей Алексеевич',
                                   'phone'=> '8(066)-184-21-01',
                                   'address' => 'ул Роскошная дом 4 квартира 2',
                                   'id_position' => '1',
                                   'status' => '10',
                                   'archive'=> 0,
                                   'created_at' => time(),
                                   'updated_at' => time(),]);
        
        $this->insert($authManager->assignmentTable,[
                                        'item_name' => 'admin',
                                        'user_id' => 1,
                                        'created_at' => time(),
                                        ]);
        //добавляем некоторое количество тестовых пользователей
        for($i=2; $i<=30; $i++){
            $id_position = random_int(2,3);
            if($id_position == 2){
                $item_name = 'manager';
            }else{
                $item_name = 'engineer';
            }
            $this->insert('{{%user}}',['id' => $i,
                                   'auth_key' => Yii::$app->security->generateRandomString(),
                                   'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
                                   'password_reset_token' => NULL,
                                   'email' => 'test-'.$i.'@gmail.com',
                                   'employeename' => 'Тест тестович Тестович '.$i,
                                   'phone'=> '8(066)-184-21-'.($i+10),
                                   'address' => 'ул Тестовая дом '.$i.' квартира',
                                   'id_position' => random_int(2,3),
                                   'status' => '10',
                                   'archive'=> 0,
                                   'created_at' => time(),
                                   'updated_at' => time(),]);
            
            $this->insert($authManager->assignmentTable,[
                                        'item_name' => $item_name,
                                        'user_id' => $i,
                                        'created_at' => time(),
                                        ]);
        }
                
        $this->createTable('{{%controler}}', [
            'id' => $this->primaryKey(),
            'name_controler' => $this->string(64)->notNull(),
            'alias_controler' => $this->string(64)->notNull(),
            'description' => $this->text()->notNull(),
            //'PRIMARY KEY (id)',
        ], $tableOptions);
        $this->insert('{{%controler}}',['id' => '1',
                                        'name_controler' => 'controler',
                                        'alias_controler' => 'Контролеры',
                                        'description' => 'Отвечает за добавление конролеров базу данных']);
        $this->insert('{{%controler}}',['id' => '2',
                                        'name_controler' => 'actionct',
                                        'alias_controler' => 'Действие',
                                        'description' => 'Контроллер отвечает за редактирование экщенов кантролеров']);
        $this->insert('{{%controler}}',['id' => '3',
                                        'name_controler' => 'default_developer',
                                        'alias_controler' => 'Возможности модуля developer',
                                        'description' => 'Выводить кнопки возможных действий этого модуля']);
        $this->insert('{{%controler}}',['id' => '4',
                                        'name_controler' => 'auth',
                                        'alias_controler' => 'Работа с ролями',
                                        'description' => 'Контроллер позваляет работать с ролями доступа']);
        $this->insert('{{%controler}}',['id' => '5',
                                        'name_controler' => 'acsess',
                                        'alias_controler' => 'Настройка доступа по ролям',
                                        'description' => 'Контроллер дает возможность задавать правила доступа к действиям других контроллеров']);
        $this->insert('{{%controler}}',['id' => '6',
                                        'name_controler' => 'user',
                                        'alias_controler' => 'Пользователи',
                                        'description' => 'Контроллер работы с пользователями']);
        $this->createTable('{{%action_ct}}', [
            'id' => $this->primaryKey(),
            'action_name' => $this->string(64)->notNull(),
            'alias_action' => $this->string(64)->notNull(),
            'description' => $this->text()->notNull(),
            'id_controler' => $this->integer(10)->defaultValue(null),
            //'PRIMARY KEY (id)',
            "KEY id_controler (id_controler)",
            "FOREIGN KEY (id_controler) REFERENCES controler (id) ON DELETE SET NULL ON UPDATE CASCADE",
        ], $tableOptions);
        $this->insert('{{%action_ct}}',['id' => '1',
                                        'action_name' => 'index',
                                        'alias_action' => 'Просмотр конролеров',
                                        'description' => 'Действие отвечает за отображение всех контролеров.',
                                        'id_controler' => '1']);
        $this->insert('{{%action_ct}}',['id' => '2',
                                        'action_name' => 'view',
                                        'alias_action' => 'Просмотр контролера',
                                        'description' => 'Действие отвечает за просмотр параметров контролера controler',
                                        'id_controler' => '1']);
        $this->insert('{{%action_ct}}',['id' => '3',
                                        'action_name' => 'create',
                                        'alias_action' => 'Создать контролер',
                                        'description' => 'Действие которое создает новое действие.',
                                        'id_controler' => '1']);
        $this->insert('{{%action_ct}}',['id' => '4',
                                        'action_name' => 'update',
                                        'alias_action' => 'Обновить контролер',
                                        'description' => 'Действие которое позволяет редактировать действие данного контролера.',
                                        'id_controler' => '1']);
        $this->insert('{{%action_ct}}',['id' => '5',
                                        'action_name' => 'delete',
                                        'alias_action' => 'Удалить контролер',
                                        'description' => 'Действие удаляет контроллеры.',
                                        'id_controler' => '1']);
        
        $this->insert('{{%action_ct}}',['id' => '6',
                                        'action_name' => 'index',
                                        'alias_action' => 'Все действия выбранного контроллера',
                                        'description' => 'Страница выводит все существующие действия контроллера, также дает возможность перейти к созданию нового действия, просмотру, редактированию, уже созданных действий.',
                                        'id_controler' => '2']);
        $this->insert('{{%action_ct}}',['id' => '7',
                                        'action_name' => 'view',
                                        'alias_action' => 'Просмотр действия контролера',
                                        'description' => 'Действие дает возможность просмотра информации о действие контролера',
                                        'id_controler' => '2']);
        $this->insert('{{%action_ct}}',['id' => '8',
                                        'action_name' => 'create',
                                        'alias_action' => 'Добавляет новое действие контроллера',
                                        'description' => 'Добавляет новое действие для выбранного контроллера',
                                        'id_controler' => '2']);
        $this->insert('{{%action_ct}}',['id' => '9',
                                        'action_name' => 'update',
                                        'alias_action' => 'Обновляет действие для выбранного контроллера',
                                        'description' => 'Действие обновляет информацию о действии для выбранного контроллера',
                                        'id_controler' => '2']);
        $this->insert('{{%action_ct}}',['id' => '10',
                                        'action_name' => 'delete',
                                        'alias_action' => 'Удаляет действие для выбранного контроллера',
                                        'description' => 'Удаляет Действие для выбранного контроллера',
                                        'id_controler' => '2']);
        $this->insert('{{%action_ct}}',['id' => '11',
                                        'action_name' => 'index',
                                        'alias_action' => 'Главная страница модуля',
                                        'description' => 'Выводит главную страницу модуля developer',
                                        'id_controler' => '3']);
        $this->insert('{{%action_ct}}',['id' => '12',
                                        'action_name' => 'index',
                                        'alias_action' => 'Все роли',
                                        'description' => 'Поваляет посмотреть и поработать со всеми ролями',
                                        'id_controler' => '4']);
        $this->insert('{{%action_ct}}',['id' => '13',
                                        'action_name' => 'view',
                                        'alias_action' => 'Информация о роли',
                                        'description' => 'Позволяет просмотреть информацию о роли',
                                        'id_controler' => '4']);
        $this->insert('{{%action_ct}}',['id' => '14',
                                        'action_name' => 'create',
                                        'alias_action' => 'Создает роль',
                                        'description' => 'Создает роль доступа',
                                        'id_controler' => '4']);
        $this->insert('{{%action_ct}}',['id' => '15',
                                        'action_name' => 'update',
                                        'alias_action' => 'Редактирование роли',
                                        'description' => 'Дает возможность редактировать роль',
                                        'id_controler' => '4']);
        $this->insert('{{%action_ct}}',['id' => '16',
                                        'action_name' => 'delete',
                                        'alias_action' => 'Удалить роль',
                                        'description' => 'Дает возможность удалять роли',
                                        'id_controler' => '4']);
        $this->insert('{{%action_ct}}',['id' => '17',
                                        'action_name' => 'index',
                                        'alias_action' => 'Выбор контролеера для задачи доступа к действиям',
                                        'description' => 'Страница позволяет выбрать какому контроллеру назначит права доступа',
                                        'id_controler' => '5']);
        $this->insert('{{%action_ct}}',['id' => '18',
                                        'action_name' => 'create',
                                        'alias_action' => 'Добавляет все действия контроллера с запрешенным доступом',
                                        'description' => 'Данное действие не доступно а а участвует в редактировании доступа к действиям контроллера',
                                        'id_controler' => '5']);
        $this->insert('{{%action_ct}}',['id' => '19',
                                        'action_name' => 'update',
                                        'alias_action' => 'Выводит действия и даете возможность разрешать либо запрещать',
                                        'description' => 'Выводит действия и даете возможность разрешать либо запрещать доступ к действиям контроллера',
                                        'id_controler' => '5']);
        $this->insert('{{%action_ct}}',['id' => '20',
                                        'action_name' => 'allow',
                                        'alias_action' => 'Разрешить доступ',
                                        'description' => 'Действие поваляет выбранной роли задать разрешение для действия',
                                        'id_controler' => '5']);
        $this->insert('{{%action_ct}}',['id' => '21',
                                        'action_name' => 'deny',
                                        'alias_action' => 'Запретить действие',
                                        'description' => 'Запретить для выбранной роли доступ к действию',
                                        'id_controler' => '5']);
         $this->insert('{{%action_ct}}',['id' => '22',
                                        'action_name' => 'index',
                                        'alias_action' => 'Просмотр рабочих',
                                        'description' => 'Действие отвечает за вывод всех рабочих  на экран для возможности поиска редактирования и назначения и удаления роли.',
                                        'id_controler' => '6']);
         $this->insert('{{%action_ct}}',['id' => '23',
                                        'action_name' => 'view',
                                        'alias_action' => 'Просмотр конкретного рабочего',
                                        'description' => 'Действие отвечает за просмотр информации о пользователе - рабочем.',
                                        'id_controler' => '6']);
         $this->insert('{{%action_ct}}',['id' => '24',
                                        'action_name' => 'create',
                                        'alias_action' => 'Добавить нового рабочего',
                                        'description' => 'Действие которое создает нового пользователя.',
                                        'id_controler' => '6']);
         $this->insert('{{%action_ct}}',['id' => '25',
                                        'action_name' => 'update',
                                        'alias_action' => 'Обновить данные о рабочем',
                                        'description' => 'Действие которое поваляет отредактировать информацию о пользователе.',
                                        'id_controler' => '6']);
         $this->insert('{{%action_ct}}',['id' => '26',
                                        'action_name' => 'delete',
                                        'alias_action' => 'Удалить данные о рабочем',
                                        'description' => 'Действие позволяет удалить пользователя-рабочего.',
                                        'id_controler' => '6']);
         $this->insert('{{%action_ct}}',['id' => '27',
                                        'action_name' => 'changepassword',
                                        'alias_action' => 'Изменить пароль',
                                        'description' => 'Действие позволяет сменить пароль для входа в систему для пользователя-рабочего.',
                                        'id_controler' => '6']);
         $this->insert('{{%action_ct}}',['id' => '28',
                                        'action_name' => 'asktheemployeerole',
                                        'alias_action' => 'Просмотр и добавление новой роли',
                                        'description' => 'Действие позволяет просмотреть и добавить новую роль пользователю - рабочему.',
                                        'id_controler' => '6']);
         $this->insert('{{%action_ct}}',['id' => '29',
                                        'action_name' => 'deletingauserrole',
                                        'alias_action' => 'Удаление роли у рабочего',
                                        'description' => 'Действие позволяет удалить роль у пользователя-рабочего',
                                        'id_controler' => '6']);
        $this->createTable('{{%acsess}}', [
                                            'id' => $this->primaryKey(),
                                            'item_name' => $this->string(64)->notNull(),
                                            'id_action_ct' => $this->integer(10),
                                            'rows' => $this->boolean(),
                                            //'PRIMARY KEY (id)',
                                            'KEY item_name (item_name)',
                                            'KEY id_controler (id_action_ct)',
                                            'FOREIGN KEY (item_name) REFERENCES auth_item (name) ON DELETE CASCADE ON UPDATE CASCADE',
                                            'FOREIGN KEY (id_action_ct) REFERENCES action_ct (id) ON DELETE CASCADE ON UPDATE CASCADE'
                                        ], $tableOptions);
        $this->insert('{{%acsess}}',['id' => '1', 'item_name' => 'admin', 'id_action_ct' => '1','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '2', 'item_name' => 'admin', 'id_action_ct' => '2','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '3', 'item_name' => 'admin', 'id_action_ct' => '3','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '4', 'item_name' => 'admin', 'id_action_ct' => '4','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '5', 'item_name' => 'admin', 'id_action_ct' => '5','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '6', 'item_name' => 'admin', 'id_action_ct' => '6','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '7', 'item_name' => 'admin', 'id_action_ct' => '7','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '8', 'item_name' => 'admin', 'id_action_ct' => '8','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '9', 'item_name' => 'admin', 'id_action_ct' => '9','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '10', 'item_name' => 'admin', 'id_action_ct' => '10','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '11', 'item_name' => 'admin', 'id_action_ct' => '11','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '12', 'item_name' => 'admin', 'id_action_ct' => '12','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '13', 'item_name' => 'admin', 'id_action_ct' => '13','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '14', 'item_name' => 'admin', 'id_action_ct' => '14','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '15', 'item_name' => 'admin', 'id_action_ct' => '15','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '16', 'item_name' => 'admin', 'id_action_ct' => '16','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '17', 'item_name' => 'admin', 'id_action_ct' => '17','rows' => 1]);                
        $this->insert('{{%acsess}}',['id' => '18', 'item_name' => 'admin', 'id_action_ct' => '18','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '19', 'item_name' => 'admin', 'id_action_ct' => '19','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '20', 'item_name' => 'admin', 'id_action_ct' => '20','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '21', 'item_name' => 'admin', 'id_action_ct' => '21','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '22', 'item_name' => 'admin', 'id_action_ct' => '22','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '23', 'item_name' => 'admin', 'id_action_ct' => '23','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '24', 'item_name' => 'admin', 'id_action_ct' => '24','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '25', 'item_name' => 'admin', 'id_action_ct' => '25','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '26', 'item_name' => 'admin', 'id_action_ct' => '26','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '27', 'item_name' => 'admin', 'id_action_ct' => '27','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '28', 'item_name' => 'admin', 'id_action_ct' => '28','rows' => 1]);
        $this->insert('{{%acsess}}',['id' => '29', 'item_name' => 'admin', 'id_action_ct' => '29','rows' => 1]);
        
        $this->insert('{{%acsess}}',['id' => '30', 'item_name' => 'manager', 'id_action_ct' => '1','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '31', 'item_name' => 'manager', 'id_action_ct' => '2','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '32', 'item_name' => 'manager', 'id_action_ct' => '3','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '33', 'item_name' => 'manager', 'id_action_ct' => '4','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '34', 'item_name' => 'manager', 'id_action_ct' => '5','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '35', 'item_name' => 'manager', 'id_action_ct' => '6','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '36', 'item_name' => 'manager', 'id_action_ct' => '7','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '37', 'item_name' => 'manager', 'id_action_ct' => '8','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '38', 'item_name' => 'manager', 'id_action_ct' => '9','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '39', 'item_name' => 'manager', 'id_action_ct' => '10','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '40', 'item_name' => 'manager', 'id_action_ct' => '11','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '41', 'item_name' => 'manager', 'id_action_ct' => '12','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '42', 'item_name' => 'manager', 'id_action_ct' => '13','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '43', 'item_name' => 'manager', 'id_action_ct' => '14','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '44', 'item_name' => 'manager', 'id_action_ct' => '15','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '45', 'item_name' => 'manager', 'id_action_ct' => '16','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '46', 'item_name' => 'manager', 'id_action_ct' => '17','rows' => 0]);                
        $this->insert('{{%acsess}}',['id' => '47', 'item_name' => 'manager', 'id_action_ct' => '18','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '48', 'item_name' => 'manager', 'id_action_ct' => '19','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '49', 'item_name' => 'manager', 'id_action_ct' => '20','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '50', 'item_name' => 'manager', 'id_action_ct' => '21','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '51', 'item_name' => 'manager', 'id_action_ct' => '22','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '52', 'item_name' => 'manager', 'id_action_ct' => '23','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '53', 'item_name' => 'manager', 'id_action_ct' => '24','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '54', 'item_name' => 'manager', 'id_action_ct' => '25','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '55', 'item_name' => 'manager', 'id_action_ct' => '26','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '56', 'item_name' => 'manager', 'id_action_ct' => '27','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '57', 'item_name' => 'manager', 'id_action_ct' => '28','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '58', 'item_name' => 'manager', 'id_action_ct' => '29','rows' => 0]);
        
        $this->insert('{{%acsess}}',['id' => '59', 'item_name' => 'engineer', 'id_action_ct' => '1','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '60', 'item_name' => 'engineer', 'id_action_ct' => '2','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '61', 'item_name' => 'engineer', 'id_action_ct' => '3','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '62', 'item_name' => 'engineer', 'id_action_ct' => '4','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '63', 'item_name' => 'engineer', 'id_action_ct' => '5','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '64', 'item_name' => 'engineer', 'id_action_ct' => '6','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '65', 'item_name' => 'engineer', 'id_action_ct' => '7','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '66', 'item_name' => 'engineer', 'id_action_ct' => '8','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '67', 'item_name' => 'engineer', 'id_action_ct' => '9','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '68', 'item_name' => 'engineer', 'id_action_ct' => '10','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '69', 'item_name' => 'engineer', 'id_action_ct' => '11','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '70', 'item_name' => 'engineer', 'id_action_ct' => '12','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '71', 'item_name' => 'engineer', 'id_action_ct' => '13','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '72', 'item_name' => 'engineer', 'id_action_ct' => '14','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '73', 'item_name' => 'engineer', 'id_action_ct' => '15','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '74', 'item_name' => 'engineer', 'id_action_ct' => '16','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '75', 'item_name' => 'engineer', 'id_action_ct' => '17','rows' => 0]);                
        $this->insert('{{%acsess}}',['id' => '76', 'item_name' => 'engineer', 'id_action_ct' => '18','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '77', 'item_name' => 'engineer', 'id_action_ct' => '19','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '78', 'item_name' => 'engineer', 'id_action_ct' => '20','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '79', 'item_name' => 'engineer', 'id_action_ct' => '21','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '80', 'item_name' => 'engineer', 'id_action_ct' => '22','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '81', 'item_name' => 'engineer', 'id_action_ct' => '23','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '82', 'item_name' => 'engineer', 'id_action_ct' => '24','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '83', 'item_name' => 'engineer', 'id_action_ct' => '25','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '84', 'item_name' => 'engineer', 'id_action_ct' => '26','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '85', 'item_name' => 'engineer', 'id_action_ct' => '27','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '86', 'item_name' => 'engineer', 'id_action_ct' => '28','rows' => 0]);
        $this->insert('{{%acsess}}',['id' => '87', 'item_name' => 'engineer', 'id_action_ct' => '29','rows' => 0]);
        
        
    }

    public function down()
    {
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;

        if ($this->isMSSQL()) {
            $this->execute('DROP TRIGGER dbo.trigger_auth_item_child;');
        }
        
        $this->dropTable('{{%user}}');
        $this->dropTable($authManager->assignmentTable);
        $this->dropTable($authManager->itemChildTable);
        $this->dropTable($authManager->itemTable);
        $this->dropTable($authManager->ruleTable);
        $this->dropTable('{{%controler}}');
        $this->dropTable('{{%action_ct}}');
    }
}
