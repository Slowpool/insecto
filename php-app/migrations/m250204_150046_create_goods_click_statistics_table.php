<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%goods_click_statistics}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%unit_of_goods}}`
 */
class m250204_150046_create_goods_click_statistics_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%goods_click_statistics}}', [
            'id' => $this->char(36)->notNull()->defaultExpression('(UUID())'),
            'unit_of_goods_id' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addPrimaryKey('pk_goods_click_statistics', '{{%goods_click_statistics}}', 'id');

        $this->createIndex(
            '{{%idx-goods_click_statistics-unit_of_goods_id}}',
            '{{%goods_click_statistics}}',
            'unit_of_goods_id'
        );

        $this->addForeignKey(
            '{{%fk-goods_click_statistics-unit_of_goods_id}}',
            '{{%goods_click_statistics}}',
            'unit_of_goods_id',
            '{{%unit_of_goods}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-goods_click_statistics-unit_of_goods_id}}',
            '{{%goods_click_statistics}}'
        );

        $this->dropIndex(
            '{{%idx-goods_click_statistics-unit_of_goods_id}}',
            '{{%goods_click_statistics}}'
        );

        $this->dropTable('{{%goods_click_statistics}}');
    }
}
