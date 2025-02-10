<?php

namespace app\components\behaviors;

use yii\behaviors\AttributeBehavior;

class PercentageConversionBehavior extends AttributeBehavior {
    /**
     * The attribute, the value of which is taken as 100% value.
     * @var 
     */
    public $attribute; // E.g. 200
    /**
     * The attribute, which is a part of a 100% value.
     * @var 
     */
    public $partOfAttribute; // E.g. 50. 50 is part of 200
    /**
     * The attribute, which is a percentage difference between the `attribute` and `partOfAttribute`.
     * @var 
     */
    public $percentage; // E.g. 25%. 50 is 25% of 200.

    public function events() {
        return [
            \yii\base\Model::EVENT_BEFORE_VALIDATE => 'calculateAbsoluteOrPercentage'
        ];
    }

    public function calculateAbsoluteOrPercentage($event) {
        $attributeValue = $this->owner->{$this->attribute};
        $part = $this->owner->{$this->partOfAttribute};
        $percentage = $this->owner->{$this->percentage};
        if ($part) {
            $this->owner->{$this->percentage} = self::calculatePercentage($attributeValue, $part);
        }
        elseif($percentage) {
            $this->owner->{$this->partOfAttribute} = self::calculatePart($attributeValue, $percentage);
        }
        else {
            throw new \\Exception('failed');
        }
    }

    // TODO it should be in helper!
    private function calculatePercentage(int $numerator, int $denominator) {

    }
}