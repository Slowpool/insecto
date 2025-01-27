<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%unit_of_goods}}`.
 * Has foreign keys to the tables:
 * @var $this m250127_120639_create_unit_of_goods_table
 *
 * - `{{%category}}`
 */
class m250127_120639_create_unit_of_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%unit_of_goods}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->check('LENGTH(TRIM(name)) > 0'),
            'description' => $this->string()->check('LENGTH(TRIM(description)) > 0'),
            'atomic_item_measure' => $this->char(1)->notNull()->check('atomic_item_measure in (\'g\', \'u\')')->comment('g - gramm, u - unit'),
            'atomic_item_quantity' => $this->integer()->notNull()->check('atomic_item_quantity > 0'),
            'number_of_remaining' => $this->integer()->notNull()->check('number_of_remaining >= 0'),
            'category_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-unit_of_goods-category_id}}',
            '{{%unit_of_goods}}',
            'category_id'
        );

        // add foreign key for table `{{%category}}`
        $this->addForeignKey(
            '{{%fk-unit_of_goods-category_id}}',
            '{{%unit_of_goods}}',
            'category_id',
            '{{%goods_category}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%category}}`
        $this->dropForeignKey(
            '{{%fk-unit_of_goods-category_id}}',
            '{{%unit_of_goods}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-unit_of_goods-category_id}}',
            '{{%unit_of_goods}}'
        );

        $this->dropTable('{{%unit_of_goods}}');
    }
}
