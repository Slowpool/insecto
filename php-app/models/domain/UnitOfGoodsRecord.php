<?php

namespace app\models\domain;

use app\models\category\CommonCategorizedFilter;
use app\models\search\SearchModel;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\web\UploadedFile;

/**
 * This is the model class for table "unit_of_goods".
 *
 * @property int $id
 * @property string $name is not unique. Explanation: e.g. different providers can sell goods with the same name (several goods items with name Firefly seem not just pretty possible, but quite possible), or even one provider. In other words, the subject area doesn't imply unique goods names.
 * @property string $slug is not unique, according to $name.   
 * @property ?string $description
 * @property string $atomic_item_measure g - gramm, u - unit
 * @property int $atomic_item_quantity e.g. 200. when atomic_item_measure is 'g' this would mean that one goods unit weighs 200gramm. 200-gramms-of-mosquitoes box = atomic goods item for sale
 * @property int $number_of_remaining e.g. 3. it would mean that 3 boxes of 200g mosquito are remaining
 * @property int $price
 * @property int $is_alive
 * @property ?string $main_picture
 *
 * @property int $category_id
 * @property GoodsCategoryRecord $category
 * @property ?GoodsCategoryRecord $priceOffer
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
            [['id', 'name', 'description', 'atomic_item_measure', 'atomic_item_quantity', 'number_of_remaining', 'category_id', 'is_alive', 'price', 'main_picture'], 'safe'],
            [['name', 'atomic_item_measure', 'atomic_item_quantity', 'number_of_remaining', 'category_id', 'is_alive'], 'required'],
            [['atomic_item_quantity', 'number_of_remaining', 'category_id', 'price'], 'integer'],
            [['name', 'slug'], 'string', 'max' => DB_GOODS_NAME_MAX_LEN],
            [['description'], 'string', 'max' => DB_GOODS_DESCRIPTION_MAX_LEN],
            [['main_picture'], 'string', 'max' => DB_GOODS_MAIN_PICTURE_MAX_LEN],
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

    public function getPriceOffer()
    {
        return $this->hasOne(PriceOfferRecord::class, ['unit_of_goods_id' => 'id']);
    }

    /**
     * @param \app\models\category\CommonCategorizedFilter $filter
     * @param bool $asArray
     * @var yii\db\ActiveQuery $query
     */
    public static function searchWithFilter(string $categoryName, CommonCategorizedFilter $filter, bool $asArray = true)
    {
        $query = self::find()
            ->with('priceOffer');

        $categoryId = GoodsCategoryRecord::find()->where(['name' => $categoryName])->select(['id']);
        $query = $query->where(['category_id' => $categoryId]);

        if ($filter->isAlive !== null) {
            $query = $query->andWhere(['is_alive' => $filter->isAlive]);
        }

        if ($filter->isAvailable !== null) {
            $query = $query->andWhere(['>', 'number_of_remaining', 0]);
        }

        if ($filter->minPrice !== null) {
            $query = $query->andWhere(['>=', 'price', $filter->minPrice]);
        }

        if ($filter->maxPrice !== null) {
            $query = $query->andWhere(['<=', 'price', $filter->maxPrice]);
        }

        if ($asArray) {
            $query = $query->asArray();
        }
        return $query->all();
    }

    public static function searchEverywhere(SearchModel $searchModel, $asArray = true): self|array|null
    {
        $query = self::find()
            // the simplest way to attach category. the second one is via join, which would allow to avoid overheaded category's id selecting, having decreased the size of data transported from db to app, but, you know. JOIN takes time. it's not worth it in this case
            ->with(['category', 'priceOffer'])
            ->where(['like', 'name', $searchModel->q]);
        // docs quote: `Using the Hash Format, Yii internally applies parameter binding for values, so in contrast to the string format, here you do not have to add parameters manually.`
        // [':searchText' => $searchModel->searchText]


        if ($asArray) {
            $query = $query->asArray();
        }
        return $query->all();
    }

    /**
     * 
     * @param string $categorySlug
     * @param string $goodsSlug
     * @param int $goodsItemId
     * @var UnitOfGoodsRecord $goodsItem
     * @return array|Yii\db\ActiveRecord|null
     */
    public static function searchOne(string $categorySlug, string $goodsSlug, int $goodsItemId): self|null
    {
        $goodsItem = self::find()
            ->where(['id' => $goodsItemId])
            ->with(['category', 'priceOffer'])
            ->one();
        return $goodsItem && $goodsItem->category->slug == $categorySlug && $goodsItem->slug == $goodsSlug
            ? $goodsItem
            : null;
    }

    /**
     * 
     * @param int $maxRecords The maximum number of records to return.
     * @return UnitOfGoodsRecord[]
     */
    public static function findTheMostPopular(int $maxRecords)
    {
        // table aliases (abbreviations)
        $uogr = 'uogr';
        $gcs = 'gcs';
        $unitOfGoodsColumns = [
            "$uogr.id",
            "$uogr.name",
            "$uogr.slug",
            "$uogr.description",
            "$uogr.atomic_item_measure",
            "$uogr.atomic_item_quantity",
            "$uogr.number_of_remaining",
            "$uogr.price",
            "$uogr.is_alive",
            "$uogr.category_id",
        ];
        return self::find()
            ->with(['category', 'priceOffer'])
            ->alias($uogr)
            ->select($unitOfGoodsColumns)
            ->leftJoin("goods_click_statistics $gcs", "$gcs.unit_of_goods_id = $uogr.id")
            // if you group only by id, then other goods item columns would be ungrouped
            ->groupBy($unitOfGoodsColumns)
            // to prevent the case when all goods items have 0 clicks and consequently they would be selected in random order
            ->having("COUNT($gcs.unit_of_goods_id) > 0")
            ->orderBy("COUNT($gcs.unit_of_goods_id) DESC")
            ->limit($maxRecords)
            ->all()
        ;
    }

    /**
     * 
     * @param int $maxRecords The maximum number of records to return.
     * @return UnitOfGoodsRecord[] Ordered according to offer priority rank
     */
    public static function findDiscounted(int $maxRecords)
    {
        return self::find()
            ->with('category')
            // the first time in my life i'm using RIGHT JOIN
            // upd: actually both INNER and RIGHT joins are possible here due to uniqueness of `price_offer` regarding the `unit_of_goods`
            ->joinWith('priceOffer', true, 'RIGHT JOIN')
            ->where(['NOT', ['price_offer.priority_rank' => null]])
            ->orderBy('price_offer.priority_rank ASC')
            ->limit($maxRecords)
            ->all();
    }

    public static function incrementNumberOfRemaining(int $unitOfGoodsId, int $numberOfReceived): void
    {
        $record = self::findOne(['id' => $unitOfGoodsId]);
        if ($record === null) {
            throw new \Exception("The record with id $unitOfGoodsId not found");
        }
        $record->number_of_remaining += $numberOfReceived;
        if (!$record->update(false)) {
            throw new \yii\db\Exception('Failed to update: database error');
        }
    }

    public static function died(int $unitOfGoodsId, int $numberOfDied, bool $sellDied): void
    {
        $record = self::findOne(['id' => $unitOfGoodsId]);
        if (!$record->is_alive) {
            throw new \Exception('It is already died');
        }
        $transaction = Yii::$app->db->beginTransaction();
        switch ($record->number_of_remaining <=> $numberOfDied) {
            case -1:
                $transaction->rollBack();
                throw new \Exception("The number of died is greater than the number of all");
            // all died
            case 0:
                $record->is_alive = false;
                $record->price = self::reducePrice($record->price, DISCOUNT_ON_DEAD);
                break;
            // some part died
            case 1:
                $record->number_of_remaining -= $numberOfDied;
                if ($sellDied) {
                    if ($diedGoodsRecord = self::findDeadVersion($record)) {
                        $diedGoodsRecord->number_of_remaining += $numberOfDied;
                    } else {
                        $diedGoodsRecord = new self;
                        $diedGoodsRecord->attributes = $record->attributes;

                        $diedGoodsRecord->id = null;
                        $diedGoodsRecord->is_alive = false;
                        $diedGoodsRecord->number_of_remaining = $numberOfDied;
                        $diedGoodsRecord->price = self::reducePrice($diedGoodsRecord->price, DISCOUNT_ON_DEAD);
                    }

                    if (!$diedGoodsRecord->save()) {
                        $transaction->rollBack();
                        throw new \yii\db\Exception('Failed to save new died goods item record');
                    }
                }
                break;
        }
        if (!$record->update()) {
            $transaction->rollBack();
            throw new \yii\db\Exception('Failed to update the primary goods item record');
        }
        $transaction->commit();
    }

    // TODO it should be in PriceHelper-like
    public static function reducePrice(int $price, int $discountPercentage)
    {
        return (int) ($price * ((100 - $discountPercentage) / 100)) ?: 1;
    }

    public static function findDeadVersion(self $record)
    {
        return self::findOne([
            'name' => $record->name,
            'is_alive' => false,
            'atomic_item_quantity' => $record->atomic_item_quantity,
            'atomic_item_measure' => $record->atomic_item_measure,
        ]);
    }

    public static function updateMainPicture(int $unitOfGoodsId, UploadedFile $picture): void
    {
        $record = self::findOne(['id' => $unitOfGoodsId]);
        if ($record === null) {
            throw new \Exception('Unit of goods with such an id not found', 404);
        }

        // TODO handle too long file name
        // TODO handle the case when a file with the same name  
        $relativePath = "goods-item/$unitOfGoodsId/$picture->baseName.$picture->extension";
        $picture->saveAs("@app/web/$relativePath");
        $record->main_picture = "/$relativePath";
        try {
            $record->update(false);
        }
        catch (\Exception $e) {
            // TODO remove file
            Yii::error($e->getMessage(), 'db');
            throw new \Exception();
        }
    }
}
