<?php

namespace app\models\price_offer;

class PriceOfferViaDiscountModel extends \yii\base\Model
{
    /** @var int */
    public $unitOfGoodsId;
    /** @var int */
    public $discountPercentage;
    public function rules(): array
    {
        return [
            [['unitOfGoodsId'], 'integer', 'min' => 1, 'max' => PHP_INT_MAX],
            [['discountPercentage'], 'integer', 'min' => MIN_DISCOUNT_PERCENTAGE, 'max' => MAX_DISCOUNT_PERCENTAGE],
            [['unitOfGoodsId', 'discountPercentage'], 'required'],
        ];
    }
}