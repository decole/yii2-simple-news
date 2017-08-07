<?php

use yii\db\Migration;

class m170726_215543_user_table extends Migration
{
    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170726_215543_user_table cannot be reverted.\n";

        return false;
    }

    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey()->unique(),
            'username' => $this->string(255)->notNull()->unique(),
            'password' => $this->string(255),
            'auth_key' => $this->string(255),
            'access_token' => $this->string(255),
            'email_confirm' => $this->string(255), // токен для подтверждения почты
            'email' => $this->string(255), // токен для подтверждения почты
            'create_date' => $this->datetime()->notNull(),
            'update_date' => $this->datetime()->notNull(),
        ]);

    }

    public function down()
    {
        $this->dropTable('user');
    }
}
