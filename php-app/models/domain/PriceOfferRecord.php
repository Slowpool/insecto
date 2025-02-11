<?php

namespace app\models\domain;

use Yii;

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

    public static function createViaPrice(int $unitOfGoodsId, int $newPrice)
    {
        self::create([
            'unit_of_goods_id' => $unitOfGoodsId,
            'new_price' => $newPrice
        ], 'Failed to save new price offer via price');
    }

    public static function createViaDiscountPercentage(int $unitOfGoodsId, int $discountPercentage)
    {
        self::create([
            'unit_of_goods_id' => $unitOfGoodsId,
            'discount_percentage' => $discountPercentage
        ], 'Failed to save new price offer via price');
    }

    /**
     * When price offer is already exist for specified `unitOfGoodsId`, this method removes it and creates a new one.
     * @param array $config
     * @param string $errorMessage
     * @throws \Exception
     * @throws \yii\db\Exception
     * @return void
     */
    public static function create(array $config, string $errorMessage)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $record = new self($config);
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

}
