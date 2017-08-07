<?php

use yii\db\Migration;

class m170806_080211_add_column_notification extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user', 'is_confirm', $this->boolean());
        $this->addColumn('user', 'notification', $this->boolean());
    }

    public function safeDown()
    {
        echo "m170806_080211_add_column_notification cannot be reverted.\n";
        $this->dropColumn('user', 'is_confirm');
        $this->dropColumn('user', 'notification');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170806_080211_add_column_notification cannot be reverted.\n";

        return false;
    }
    */
}
