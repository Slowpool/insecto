<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%unit_of_goods}}`.
 */
class m250127_153330_add_is_alive_column_to_unit_of_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%unit_of_goods}}',
            'is_alive',
            $this->boolean()->notNull()->defaultValue(false)
        );
        $this->update('unit_of_goods', ['is_alive' => true], ['name' => 'Danaida monarch']);
        $this->update('unit_of_goods', ['is_alive' => true], ['name' => 'Firefly']);
        $this->update('unit_of_goods', ['is_alive' => true], ['name' => 'Goliath Birdeater']);
        $this->update('unit_of_goods', ['is_alive' => true], ['name' => 'Heteropteryx dilatata']);
        $this->update('unit_of_goods', ['is_alive' => true], ['name' => 'Master Mantis']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%unit_of_goods}}', 'is_alive');
    }
}
