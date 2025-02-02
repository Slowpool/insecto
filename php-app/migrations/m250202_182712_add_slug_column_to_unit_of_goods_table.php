<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%unit_of_goods}}`.
 */
class m250202_182712_add_slug_column_to_unit_of_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%unit_of_goods}}', 'slug', $this->string(50)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%unit_of_goods}}', 'slug');
    }
}
