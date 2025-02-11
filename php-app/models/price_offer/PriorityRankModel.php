<?php

namespace app\models\price_offer;

class PriorityRankModel extends \yii\base\Model {
    /** @var bool */
    public $shift;
    /** @var int */
    public $rank;
    public function rules() {
        return [
            [['shift', 'rank'], 'required'],
            [['shift'], 'boolean'],
            [['rank'], 'integer', 'min' => 1, 'max' => DB_INT_MAX],
        ];
    }
}