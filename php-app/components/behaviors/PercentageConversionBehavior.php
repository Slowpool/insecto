<?php

namespace app\components\behaviors;

use yii\behaviors\AttributeBehavior;

class PercentageConversionBehavior extends AttributeBehavior
{
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

    public function events()
    {
        return [
            \yii\base\Model::EVENT_BEFORE_VALIDATE => 'calculateAbsoluteOrPercentage'
        ];
    }

    public function calculateAbsoluteOrPercentage($event)
    {
        $owner = $this->owner;
        $attributeValue = $owner->{$this->attribute};
        $part = $owner->{$this->partOfAttribute};
        $percentage = $owner->{$this->percentage};
        if ($part) {
            $owner->{$this->percentage} = 100 - self::calculatePercentage($part, $attributeValue);
        } elseif ($percentage) {
            $owner->{$this->partOfAttribute} = $attributeValue - self::calculatePart($percentage, $attributeValue);
        }
    }

    // TODO it should be in helper!
    private function calculatePercentage(int $part, int $entire): int
    {
        return (int) ($part / $entire * 100);
    }

    private function calculatePart(int $percentage, int $entire)
    {
        return (int) ($entire * $percentage / 100);
    }
}