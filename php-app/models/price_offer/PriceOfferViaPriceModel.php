<?php

namespace app\models\price_offer;

class PriceOfferViaPriceModel extends PriceOfferViaSomethingModel
{
    /** @var int */
    public $newPrice;
    public function rules(): array
    {
        return [
            ...parent::rules(),
            [['newPrice'], 'integer', 'min' => 1, 'max' => DB_INT_MAX],
            [['newPrice'], 'required'],
        ];
    }
}