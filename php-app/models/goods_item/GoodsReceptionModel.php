<?php

namespace app\models\goods_item;

class GoodsReceptionModel extends \yii\base\Model
{
    /** @var int */
    public $unitOfGoodsId;
    /** @var int */
    public $numberOfReceived;

    public function rules()
    {
        return [
            // TODO still a problem with php max int and mysql max int (the first one constists of 64 bytes, the second one - of 32)
            [['numberOfReceived', 'unitOfGoodsId'], 'integer', 'min' => 1, 'max' => DB_INT_MAX],
        ];
    }
}