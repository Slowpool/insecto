<?php

namespace app\models\price_offer;

class PriceOfferViaDiscountModel extends \yii\base\Model
{
    /** @var int */
    public $goodsItemId;
    /** @var int */
    public $discountPercentage;
    public function rules(): array
    {
        return [
            [['goodsItemId'], 'integer', 'min' => 1, 'max' => PHP_INT_MAX],
            [['discountPercentage'], 'integer', 'max' => 99],
            [['goodsItemId', 'discountPercentage'], 'required'],
        ];
    }
}