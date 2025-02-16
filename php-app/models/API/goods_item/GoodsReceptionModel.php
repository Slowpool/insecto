<?php

namespace app\models\API\goods_item;

/**
 * @OA\Schema()
 */
class GoodsReceptionModel extends \yii\base\Model
{
    /** @var int */
    public $unitOfGoodsId;
    /** @var int */
    public $numberOfReceived;

    public function rules()
    {
        return [
            [['numberOfReceived', 'unitOfGoodsId'], 'integer', 'min' => 1, 'max' => DB_INT_MAX],
        ];
    }
}