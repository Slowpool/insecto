<?php

namespace app\models\API\price_offer;

/**
 * @OA\Schema()
 */
class PriceOfferViaPriceModel extends PriceOfferViaSomethingModel
{
    /**
     * @var int
     * @OA\Property()
     */
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