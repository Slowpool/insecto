<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%price_offer}}`.
 */
class m250208_170500_add_discount_percentage_column_to_price_offer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%price_offer}}', 'discount_percentage', $this->integer()->notNull()->check('discount_percentage > 0 AND discount_percentage < 100'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%price_offer}}', 'discount_percentage');
    }
}
