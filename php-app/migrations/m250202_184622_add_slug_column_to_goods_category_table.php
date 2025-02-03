<?php

require_once __DIR__ . '/../config/consts.php';

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%goods_category}}`.
 */
class m250202_184622_add_slug_column_to_goods_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%goods_category}}', 'slug', $this->string(DB_GOODS_NAME_MAX_LEN)->notNull()->unique());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%goods_category}}', 'slug');
    }
}
