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
            'id' => $this->primaryKey(),
            'unit_of_goods_id' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `unit_of_goods_id`
        $this->createIndex(
            '{{%idx-goods_click_statistics-unit_of_goods_id}}',
            '{{%goods_click_statistics}}',
            'unit_of_goods_id'
        );

        // add foreign key for table `{{%unit_of_goods}}`
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
        // drops foreign key for table `{{%unit_of_goods}}`
        $this->dropForeignKey(
            '{{%fk-goods_click_statistics-unit_of_goods_id}}',
            '{{%goods_click_statistics}}'
        );

        // drops index for column `unit_of_goods_id`
        $this->dropIndex(
            '{{%idx-goods_click_statistics-unit_of_goods_id}}',
            '{{%goods_click_statistics}}'
        );

        $this->dropTable('{{%goods_click_statistics}}');
    }
}
