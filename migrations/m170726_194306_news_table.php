<?php

use yii\db\Migration;

class m170726_194306_news_table extends Migration
{
    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170726_194306_news_table cannot be reverted.\n";

        return false;
    }

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
		$this->createTable('news', [
            'id' => $this->primaryKey()->unique(),
            'title' => $this->string(255)->notNull(),
            'preview_text' => $this->text(),
            'detail_text' => $this->text(),
            'published' => $this->boolean(),
            'deleted' => $this->boolean(),
            'user_id' => $this->integer()->notNull(),
            'create_date' => $this->datetime()->notNull(),
            'update_date' => $this->datetime()->notNull(),
        ]);
		
    }

    public function down()
    {
		$this->dropTable('news');
    }
    
}
