<?php

namespace app\models\goods_item;

class GoodsDiedModel extends \yii\base\Model
{
    /** @var int */
    public $unitOfGoodsId;
    /** @var int */
    public $numberOfDied;
    /** @var bool */
    public $sellDied;

    public function rules()
    {
        return [
            [['unitOfGoodsId', 'numberOfDied'], 'integer', 'min' => 1, 'max' => PHP_INT_MAX],
            [['sellDied'], 'boolean'],
        ];
    }
}