<?php

namespace app\models\domain;

use Yii;

/**
 * This is the model class for table "price_offer".
 *
 * @property int $id
 * @property int $unit_of_goods_id
 * @property int $new_price
 * @property ?int $priority_rank to promote goods items as desired by seller
 *
 * @property UnitOfGoodsRecord $unitOfGoodsRecord
 */
class PriceOfferRecord extends \yii\db\ActiveRecord
{
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
        return [
            [['unit_of_goods_id', 'new_price'], 'required'],
            [['unit_of_goods_id', 'new_price', 'priority_rank'], 'integer'],
            [['unit_of_goods_id', 'priority_rank'], 'unique'],
            [['unit_of_goods_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnitOfGoodsRecord::class, 'targetAttribute' => ['unit_of_goods_id' => 'id']],
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
}
