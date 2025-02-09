<?php

namespace app\models\goods_item;

use yii\base\Model;

class GoodsReceptionModel extends Model
{
    public $unitOfGoodsId;
    public $numberOfReceived;

    
    public function rules()
    {
        return [
            [['numberOfReceived', 'unitOfGoodsId'], 'integer', 'min' => 1, 'max' => PHP_INT_MAX],
        ];
    }

    // private const int PROPERTIES_NUMBER = 2;

    // public function load($data, $formName = null): bool
    // {
    //     if (count($data) == self::PROPERTIES_NUMBER && self::isPreciseInt($data['numberOfReceived']) && self::isPreciseInt($data['unitOfGoodsId'])) {
    //         return parent::load($data, $formName);
    //     } else {
    //         $this->addError('Incorrect properties');
    //         return false;
    //     }
    // }

    /**
     * Returns true for "1937"-like string and false for "99999999999999999999999999999999999999999999999999999999999999999999999"-like string depending on whether the string's number is fit into php `int` range.
     * The problem: when $data contains too long values, the `load()` method throws exception on assigning of value to properties (the validation is executed after load())
     * @param mixed $string
     * @return bool
     */
    // private static function isPreciseInt($string)
    // {
    //     return (string)intval($string) === $string;
    // }


}