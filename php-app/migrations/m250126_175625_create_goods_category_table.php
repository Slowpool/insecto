<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m250126_175625_create_goods_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%goods_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->check('LENGTH(TRIM(name)) > 0'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%goods_category}}');
    }
}
