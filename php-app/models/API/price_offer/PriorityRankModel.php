<?php

namespace app\models\API\price_offer;

/**
 * @OA\Schema()
 */
class PriorityRankModel extends \yii\base\Model {
    /**
     * @var bool
     * @OA\Property()
     */
    public $shift;
    /**
     * @var int
     * @OA\Property()
     */
    public $rank;
    public function rules() {
        return [
            [['shift', 'rank'], 'required'],
            [['shift'], 'boolean'],
            [['rank'], 'integer', 'min' => 1, 'max' => DB_INT_MAX],
        ];
    }
}