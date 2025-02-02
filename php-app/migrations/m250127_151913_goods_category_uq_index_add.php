<?php

use yii\db\Migration;

class m250127_151913_goods_category_uq_index_add extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            '{{%goods_category_name_uq_index}}',
            '{{%goods_category}}',
            ['name'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            '{{%goods_category_name_uq_index}}',
            '{{%goods_category}}'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250127_151913_goods_category_uq_index_add cannot be reverted.\n";

        return false;
    }
    */
}
