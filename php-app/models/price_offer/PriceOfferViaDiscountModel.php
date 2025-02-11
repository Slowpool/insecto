<?php

namespace app\models\price_offer;

class PriceOfferViaDiscountModel extends PriceOfferViaSomethingModel
{
    /** @var int */
    public $discountPercentage;
    public function rules(): array
    {
        return [
            ...parent::rules(),
            [['discountPercentage'], 'integer', 'min' => MIN_DISCOUNT_PERCENTAGE, 'max' => MAX_DISCOUNT_PERCENTAGE],
            [['discountPercentage'], 'required'],
        ];
    }
}