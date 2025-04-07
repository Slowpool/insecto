<?php

namespace app\models\API\price_offer;

class PriceOfferOnCategoryModel extends \yii\base\Model
{
    /** @var string */
    public $categoryName;
    /** @var int */
    public $discountPercentage;
    public function rules()
    {
        return [
            [['categoryName'], 'string', 'max' => DB_CATEGORY_NAME_MAX_LEN],
            [['discountPercentage'], 'integer', 'min' => MIN_DISCOUNT_PERCENTAGE, 'max' => MAX_DISCOUNT_PERCENTAGE],
            [['categoryName', 'discountPercentage'], 'required'],
        ];
    }
}