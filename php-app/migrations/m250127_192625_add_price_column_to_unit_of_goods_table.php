<?php

require_once __DIR__ . '/../config/consts.php';

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
            $this->integer()->notNull()->check('price > 0'),
        );
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
