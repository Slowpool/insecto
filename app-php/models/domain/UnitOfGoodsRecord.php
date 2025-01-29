<?php

namespace app\models\domain;

use app\models\search\SearchModel;
use Yii;

/**
 * This is the model class for table "unit_of_goods".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $atomic_item_measure g - gramm, u - unit
 * @property int $atomic_item_quantity e.g. 200. when atomic_item_measure is 'g' this would mean that one goods unit weighs 200gramm. 200-gramms-of-mosquitoes box = atomic goods item for sale
 * @property int $number_of_remaining e.g. 3. it would mean that 3 boxes of 200g mosquito are remaining
 * @property int $category_id
 *
 * @property GoodsCategoryRecord $category
 */
class UnitOfGoodsRecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unit_of_goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','atomic_item_measure', 'atomic_item_quantity', 'number_of_remaining', 'category_id'], 'required'],
            [['atomic_item_quantity', 'number_of_remaining', 'category_id', 'price'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
            [['atomic_item_measure'], 'string', 'max' => 1],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => GoodsCategoryRecord::class, 'targetAttribute' => ['category_id' => 'id']],
            [['is_alive'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'atomic_item_measure' => 'Atomic Item Measure',
            'atomic_item_quantity' => 'Atomic Item Quantity',
            'number_of_remaining' => 'Number Of Remaining',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(GoodsCategoryRecord::class, ['id' => 'category_id']);
    }

    public static function search(SearchModel $searchModel, $asArray = false) {
        $categoryIds = GoodsCategoryRecord::getIds($searchModel->categories);
        $query = self::find();

        // regulates `where` statement so that it would be correct, not like 'AND WHERE AND WHERE', but like 'WHERE' or 'WHERE AND WHERE'.
        // it could have been done in another way, but this one is the most simpler
        $currentWhere = 'where';
        if ($searchModel->searchText) {
        // TODO is name correctly bracketed here? check it using sqlserver
            $query = $query->$currentWhere('name LIKE %:searchText%', [':searchText' => $searchModel->searchText]);
            $currentWhere = 'andWhere';
        }

        if($categoryIds) { 
            $query->$currentWhere(['category_id' => $categoryIds]);
            $currentWhere = 'andWhere';
        }

        if($searchModel->isAlive !== null) { 
            $query->$currentWhere(['is_alive' => $searchModel->isAlive]);
            $currentWhere = 'andWhere';
        }

        if($searchModel->isAvailable !== null) { 
            $query->$currentWhere('number_of_remaining > 0');
            $currentWhere = 'andWhere';
        }

        if($searchModel->minPrice !== null) { 
            $query->$currentWhere('price >= :minPrice', [':minPrice' => $searchModel->minPrice]);
            $currentWhere = 'andWhere';
        }

        if($searchModel->maxPrice !== null) { 
            $query->$currentWhere('price <= :maxPrice', [':maxPrice' => $searchModel->maxPrice]);
            $currentWhere = 'andWhere';
        }

        if ($asArray) {
            $query = $query->asArray();
        }
        return $query->all();
    }
}
