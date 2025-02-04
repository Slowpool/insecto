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
            // TODO replace with GUID
            'id' => $this->primaryKey(),
            'unit_of_goods_id' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // TODO wait. this is awful approach. this way website owner has no flexibility of reconfiguring the click expiration. it would require this migration redoing, which may be fatal when further migrations contain some new data, that will be erased.
        $click_expiration_measure = CLICK_EXPIRATION_MEASURE;
        $click_expiration = CLICK_EXPIRATION;
        $this->execute("CREATE PROCEDURE CLEAR_OUTDATED_CLICKS()
        BEGIN
            DELETE FROM `goods_click_statistics`
            WHERE TIMESTAMPDIFF($click_expiration_measure, `created_at`, CURRENT_TIMESTAMP) >= $click_expiration;
        END
        ");

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

        $this->execute("DROP PROCEDURE IF EXISTS CLEAR_OUTDATED_CLICKS");

        $this->dropTable('{{%goods_click_statistics}}');
    }
}
