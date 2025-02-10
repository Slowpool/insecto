<?php

namespace app\models\price_offer;

class PriceOfferViaPriceModel extends \yii\base\Model
{
    /** @var int */
    public $goodsItemId;
    /** @var int */
    public $newPrice;
    public function rules(): array
    {
        return [
            [['goodsItemId', 'newPrice'], 'integer', 'min' => 1, 'max' => PHP_INT_MAX],
            [['goodsItemId', 'newPrice'], 'required'],
        ];
    }
}