<?php

namespace app\models\API\price_offer;

class PriceOfferOnCategoryModel extends \yii\base\Model
{
    /** @var int */
    public $categoryId;
    /** @var int */
    public $discountPercentage;
    public function rules()
    {
        return [
            [['categoryId'], 'integer', 'min' => 1, 'max' => DB_INT_MAX],
            [['discountPercentage'], 'integer', 'min' => MIN_DISCOUNT_PERCENTAGE, 'max' => MAX_DISCOUNT_PERCENTAGE],
            [['categoryId', 'discountPercentage'], 'required'],
        ];
    }
}