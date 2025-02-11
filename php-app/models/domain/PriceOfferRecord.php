<?php

namespace app\models\domain;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "price_offer".
 *
 * @property int $id
 * @property int $unit_of_goods_id
 * @property int $new_price
 * @property int $discount_percentage
 * @property ?int $priority_rank to promote goods items as desired by seller
 * @property int $originalPrice note: it is not stored in database. Also it is a workaround to use PercentageConversionBehavior.
 *
 * @property UnitOfGoodsRecord $unitOfGoodsRecord
 */
class PriceOfferRecord extends \yii\db\ActiveRecord
{
    /**
     * You should assign it before insert, but hold in mind that this value won't be inserted in db.
     * @var int
     */
    public int $originalPrice;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'price_offer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        // TODO add scenarios
        return [
            [['unit_of_goods_id', 'new_price'], 'required'],
            [['unit_of_goods_id', 'new_price', 'priority_rank', 'discount_percentage'], 'integer'],
            [['unit_of_goods_id', 'priority_rank'], 'unique'],
            [['unit_of_goods_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnitOfGoodsRecord::class, 'targetAttribute' => ['unit_of_goods_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            [
                /**
                 * Ensures that before insert only one of `discount_percentage` and `new_price` is specified and converts one to another. This prevents inconsistency between `discount_percentage` and `new_price` by calculating another (empty value) automatically. In other words (visually), this behavior prevents cases when the goods item price is 100, user inserts `new_price` = 80 and he also inserts `discount_percentage` = 99, although it actually should be 20 in this case.
                 */
                'class' => \app\components\behaviors\PercentageConversionBehavior::class,
                'attribute' => 'originalPrice',
                'partOfAttribute' => 'new_price',
                'percentage' => 'discount_percentage',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_of_goods_id' => 'Unit of goods ID',
            'new_price' => 'New price',
        ];
    }

    /**
     * Gets query for [[UnitOfGoodsRecord]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnitOfGoodsRecord()
    {
        return $this->hasOne(UnitOfGoodsRecord::class, ['id' => 'unit_of_goods_id']);
    }

    /**
     * Ensures that only `newPrice` is provided, without `discountPercentage`. Also allows to not specify priority options (`priorityRank` and `shiftPriority`), setting them by default.
     * @param int $unitOfGoodsId
     * @param int $newPrice
     * @param ?int $priorityRank
     * @param bool $shiftPriority
     * @return void
     */
    public static function createViaPrice(int $unitOfGoodsId, int $newPrice, ?int $priorityRank = null, bool $shiftPriority = false)
    {
        self::create($unitOfGoodsId, $newPrice, null, $priorityRank, $shiftPriority, 'Failed to save new price offer via price');
    }

    /**
     * Ensures that only `discountPercentage` is provided, without `newPrice`. Also allows to not specify priority options (`priorityRank` and `shiftPriority`), setting them by default.
     * @param int $unitOfGoodsId
     * @param int $discountPercentage
     * @param ?int $priorityRank
     * @param bool $shiftPriority
     * @return void
     */
    public static function createViaDiscountPercentage(int $unitOfGoodsId, int $discountPercentage, ?int $priorityRank = null, bool $shiftPriority = false)
    {
        self::create($unitOfGoodsId, null, $discountPercentage, $priorityRank, $shiftPriority, 'Failed to save new price offer via discount percentage');
    }

    /**
     * When price offer is already exist for specified `unitOfGoodsId`, this method removes it and creates a new one.
     * @param array $config
     * @param string $errorMessage the message to display to user in case of database error (details of this error are hidden from user, but user gets this `errorMessage`)
     * @var yii\db\ActiveRecord $unitOfGoodsRecord 
     * @throws \Exception
     * @throws \yii\db\Exception
     * @return void
     */
    private static function create(int $unitOfGoodsId, ?int $newPrice, ?int $discountPercentage, ?int $priorityRank, bool $shiftPriority, string $errorMessage)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if($priorityRank && $shiftPriority && self::find()->where(['priority_rank' => $priorityRank])->exists()) {
                self::shiftPriorityDown($priorityRank);
            }
            
            $record = new self([
                'unit_of_goods_id' => $unitOfGoodsId,
                'discount_percentage' => $discountPercentage,
                'new_price' => $newPrice,
                'priority_rank' => $priorityRank,
            ]);
            $unitOfGoodsRecord = UnitOfGoodsRecord::find()
                ->select(['price'])
                ->where(['id' => $record->unit_of_goods_id])
                ->one();

            if ($unitOfGoodsRecord == null) {
                throw new \Exception('Unit of goods with such an id not found');
            }
            // deleting of existing price offer for such a unit of goods
            if ($anotherPriceOffer = self::findOne(['unit_of_goods_id' => $record->unit_of_goods_id])) {
                $anotherPriceOffer->delete();
            }

            $record->originalPrice = $unitOfGoodsRecord->price;
            if (!$record->save()) {
                throw new \yii\db\Exception($errorMessage);
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    // TODO priceOffer should have something like `is_sale` attribute to easily stop the sale the same way that it was made. it should have name `startSale`.
    public static function createForCategory(int $categoryId, int $discountPercentage)
    {
        $categoryRecord = GoodsCategoryRecord::findOne(['id' => $categoryId]);
        if ($categoryRecord == null) {
            throw new \Exception('Such a category not found');
        }
        $unitOfGoodsRecords = UnitOfGoodsRecord::find()
            ->where(['category_id' => $categoryRecord->id])
            ->with('priceOffer')
            ->all();
        if (count($unitOfGoodsRecords) == 0) {
            throw new \Exception('There are no goods with such a category');
        }
        foreach ($unitOfGoodsRecords as $goodsItemRecord) {
            $priceOffer = $goodsItemRecord->priceOffer;
            // creating of price offer only when it reduces the price
            if ($priceOffer == null || $priceOffer->discount_percentage < $discountPercentage) {
                self::createViaDiscountPercentage($goodsItemRecord->id, $discountPercentage);
            }
        }
    }

    /**
     * Moves all priority ranks, which are below (technically higher) than `priorityRank`. E.g.: existing priority ranks: 1, 2, 3. Say, `priorityRank` = 1. This method shifts existings priority ranks to 2,3,4 to allow another price offer take the `priorityRank` place (1 in this case).
     * @param mixed $priorityRank
     * @return void
     */
    public static function shiftPriorityDown($priorityRank) {
        self::updateAllCounters(['priority_rank' => 1], ['>=', 'priority_rank', $priorityRank]);
    }

}
