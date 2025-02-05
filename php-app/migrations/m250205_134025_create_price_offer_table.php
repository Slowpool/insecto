<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%price_offer}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%unit_of_goods}}`
 */
class m250205_134025_create_price_offer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%price_offer}}', [
            'id' => $this->primaryKey(),
            'unit_of_goods_id' => $this->integer()->notNull()->unique(),
            'priority_rank' => $this->integer()->unique(),
            'new_price' => $this->integer()->notNull()->check('new_price > 0'),
        ]);

        $events = ['INSERT', 'UPDATE'];
        foreach ($events as $updateAndInsert) {
            $this->execute("CREATE TRIGGER [[price_validation_on_$updateAndInsert]]
            BEFORE $updateAndInsert
            ON {{%price_offer}}
            FOR EACH ROW
            BEGIN
                /* Ensuring that new price is less than the current one. */
                IF (SELECT [[price]] FROM {{%unit_of_goods}} WHERE [[id]] = [[new.unit_of_goods_id]]) <= [[new.new_price]] THEN
                    SIGNAL SQLSTATE '45000';
                END IF;
            END
            ");
        }

        $this->createIndex(
            '{{%idx-price_offer-unit_of_goods_id}}',
            '{{%price_offer}}',
            'unit_of_goods_id'
        );

        $this->addForeignKey(
            '{{%fk-price_offer-unit_of_goods_id}}',
            '{{%price_offer}}',
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
            '{{%fk-price_offer-unit_of_goods_id}}',
            '{{%price_offer}}'
        );

        $this->dropIndex(
            '{{%idx-price_offer-unit_of_goods_id}}',
            '{{%price_offer}}'
        );

        $this->execute("DROP TRIGGER IF EXISTS [[price_validation_on_update]]");
        $this->execute("DROP TRIGGER IF EXISTS [[price_validation_on_insert]]");

        $this->dropTable('{{%price_offer}}');
    }
}
