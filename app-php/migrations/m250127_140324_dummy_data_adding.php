<?php

use yii\db\Migration;

class m250127_140324_dummy_data_adding extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $bracketedGoodsCategory = $this->db->quoteColumnName('goods_category');
        $bracketedUnitOfGoods = $this->db->quoteColumnName('units_of_goods');
        $this->execute(
            "INSERT INTO $bracketedGoodsCategory
            VALUES (0, 'spiders'),
                (1, 'orthoptera'),
                (2, 'dragonflies'),
                (3, 'stick insects'),
                (4, 'diptera'),
                (5, 'lepidoptera');
            INSERT INTO $bracketedUnitOfGoods
            VALUES (0, 'Mosquitoe box', 'This set of mosquitoes may save your life in case you owe the box of mosquitoes to somebody who threaten you with death. Also you can use it to feed some birds like sinitsa or vorobay or even popolzen\'.', 'g', 200, 3, 4),
            (1, 'Danaida monarch', 'Such a butterflies love flowers. They can\'t fly directly (as i\'d been observing), but they are orange sometimes.', 'u', 1, 3, 5), 
            (2, 'Firefly', 'This dude emits light at night.', 'u', 10, 30, 4),
            (3, 'Goliath Birdeater', 'The biggest spider in the earth. This means it huge. Such a spiders live in ordinary houses around the whole planet in mouse style: at summer they go to forests to hunt and then, by winter, they come in our\'s, usual people\'s houses and winter somewhere close to your bed. They wake up at night and touch your food for fun, covering up tracks. If you are afraid of them quite much, you should buy one. This can be explained this way: the hut may have only one this spider as an owner, so if you already have your hand spider in cage, then you have nothing to be afraid of. These spiders can\'t stand each other, so the spider-alien will leave your hut.', 'u', 1, 183502, 0),
            (4, 'Heteropteryx dilatata', 'Heteropteryx is a monotypic genus of stick insects containing Heteropteryx dilatata as the only described species and gives its name to the family of the Heteropterygidae. Their only species may be known as jungle nymph, Malaysian stick insect, Malaysian wood nymph, Malayan jungle nymph, or Malayan wood nymph and because of their size it is commonly kept in zoological institutions and private terrariums of insect lovers. It originates from the Malay Archipelago and is nocturnal.', 'u', 1, 50, 3),
            (4, 'Master Mantis', 'Widely known actor from \"Kong Fu Panda\"', 'u', 1, 1, 3);"
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250127_140324_dummy_data_adding cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250127_140324_dummy_data_adding cannot be reverted.\n";

        return false;
    }
    */
}
