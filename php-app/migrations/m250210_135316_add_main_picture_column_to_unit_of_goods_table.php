<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%unit_of_goods}}`.
 */
class m250210_135316_add_main_picture_column_to_unit_of_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%unit_of_goods}}', 'main_picture', $this->string(DB_GOODS_MAIN_PICTURE_MAX_LEN));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%unit_of_goods}}', 'main_picture');
    }
}
