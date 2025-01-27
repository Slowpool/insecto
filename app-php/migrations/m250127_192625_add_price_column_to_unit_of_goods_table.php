<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%unit_of_goods}}`.
 */
class m250127_192625_add_price_column_to_unit_of_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%unit_of_goods}}',
            'price',
            $this->integer()->defaultValue(1)->notNull()->check('price > 0')
        );
        $this->update('unit_of_goods', ['price' => 159], ['name' => 'Mosquitoes box']);
        $this->update('unit_of_goods', ['price' => 39], ['name' => 'Danaida monarch']);
        $this->update('unit_of_goods', ['price' => 79], ['name' => 'Firefly']);
        $this->update('unit_of_goods', ['price' => 8390], ['name' => 'Goliath Birdeater']);
        $this->update('unit_of_goods', ['price' => 590], ['name' => 'Heteropteryx dilatata']);
        $this->update('unit_of_goods', ['price' => 3299], ['name' => 'Master Mantis']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // TODO is check constraint deleted too?
        $this->dropColumn('{{%unit_of_goods}}', 'price');
    }
}
