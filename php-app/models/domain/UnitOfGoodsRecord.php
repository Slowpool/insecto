<?php

namespace app\models\domain;

use app\models\search\SearchModel;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "unit_of_goods".
 *
 * @property int $id
 * @property string $name is not unique. Explanation: e.g. different providers can sell goods with the same name (several goods items with name Firefly seem not just pretty possible, but quite possible), or even one provider. In other words, the subject area doesn't imply unique goods names.
 * @property string $slug is not unique, according to $name.   
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
            [['id', 'name', 'description', 'atomic_item_measure', 'atomic_item_quantity', 'number_of_remaining', 'category_id', 'is_alive', 'price'], 'safe'],
            [['name', 'atomic_item_measure', 'atomic_item_quantity', 'number_of_remaining', 'category_id', 'is_alive'], 'required'],
            [['atomic_item_quantity', 'number_of_remaining', 'category_id', 'price'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 50],
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
            'atomic_item_measure' => 'Atomic item measure',
            'atomic_item_quantity' => 'Atomic item quantity',
            'number_of_remaining' => 'Number of remaining',
            'category_id' => 'Category ID',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
            ]
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

    /**
     * 
     * @param \app\models\search\SearchModel $searchModel
     * @param mixed $asArray
     * @var yii\db\ActiveQuery $query
     */
    public static function search(SearchModel $searchModel, $asArray = true)
    {
        $categoryIds = GoodsCategoryRecord::getIds(array_keys(array_filter($searchModel->categories)));
        $query = self::find()
            // the simplest way to attach category. the second one is via join, which would allow to avoid overheaded category's id selecting, having decreased the size of data transported from db to app, but, you know. JOIN takes time. it's not worth it in this case
            ->with('category');

        // regulating `where` statement so that it would be correct, not like 'AND WHERE AND WHERE', but like 'WHERE' or 'WHERE AND WHERE'.
        // it could have been done in another way, but this one is the most simpler
        // TODO upd: can be done this way:
        // $query->where([
        //     'status' => 10,
        //     'type' => null,
        //     'id' => [4, 8, 15],
        // ]);
        $currentWhere = 'where';
        if ($searchModel->searchText) {
            $query = $query->where(
                ['like', 'name', $searchModel->searchText],
                // docs quote `Using the Hash Format, Yii internally applies parameter binding for values, so in contrast to the string format, here you do not have to add parameters manually.`
                // [':searchText' => $searchModel->searchText]
            );
            $currentWhere = 'andWhere';
        }

        if ($categoryIds) {
            $query = $query->$currentWhere(['category_id' => $categoryIds]);
            $currentWhere = 'andWhere';
        }

        if ($searchModel->isAlive !== null) {
            $query = $query->$currentWhere(['is_alive' => $searchModel->isAlive]);
            $currentWhere = 'andWhere';
        }

        if ($searchModel->isAvailable !== null) {
            $query = $query->$currentWhere(['>', 'number_of_remaining', 0]);
            $currentWhere = 'andWhere';
        }

        if ($searchModel->minPrice !== null) {
            $query = $query->$currentWhere(['>=', 'price', $searchModel->minPrice]);
            $currentWhere = 'andWhere';
        }

        if ($searchModel->maxPrice !== null) {
            $query = $query->$currentWhere(['<=', 'price', $searchModel->maxPrice]);
            $currentWhere = 'andWhere';
        }

        if ($asArray) {
            $query = $query->asArray();
        }
        return $query->all();
    }

    public static function searchOne(string $categorySlug, string $goodsSlug, int $goodsId) {
        // TODO should i use $categorySlug $goodsSlug here at all? maybe use them just for human-readable url? or not?
    }
}
