<?php

namespace app\models\price_offer;

class PriceOfferViaSomethingModel extends \dicr\json\JsonEntity {
// class PriceOfferViaSomethingModel extends \yii\base\Model {
    /** @var int */
    public $unitOfGoodsId;
    /** @var ?PriorityRankModel */
    public $priorityRank = null;
    public function rules(): array
    {
        return [
            [['priorityRank'], 'safe'],
            [['unitOfGoodsId'], 'integer', 'min' => 1, 'max' => DB_INT_MAX],
            [['unitOfGoodsId'], 'required'],
            [['priorityRank'], 'validatePriorityRank'],
        ];
    }

    public function attributeEntities(): array {
        return [
            'priorityRank' => PriorityRankModel::class,
        ];
    }

    public function validatePriorityRank($attribute, $params) {
        if($this->priorityRank !== null && $this->priorityRank->validate()) {
            return true;
        }
        else {
            foreach($this->priorityRank->errors as $attribute => $errors) {
                foreach($errors as $error) {
                    $this->addError("priorityRank.$attribute", $error);
                }
            }
        }
    }
}