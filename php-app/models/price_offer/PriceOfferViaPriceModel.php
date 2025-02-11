<?php

namespace app\models\price_offer;

class PriceOfferViaPriceModel extends \yii\base\Model
{
    /** @var int */
    public $unitOfGoodsId;
    /** @var int */
    public $newPrice;
    public function rules(): array
    {
        return [
            [['unitOfGoodsId', 'newPrice'], 'integer', 'min' => 1, 'max' => PHP_INT_MAX],
            [['unitOfGoodsId', 'newPrice'], 'required'],
        ];
    }
}