<?php

use yii\base\Behavior;

/**
 * Ensures that before insert only one of `discount_percentage` and `new_price` is specified and converts one to another. This prevents inconsistency between `discount_percentage` and `new_price` by calculating another (empty value) automatically. In other words (visually), this behavior prevents cases when the goods item price is 100, user inserts `new_price` = 80 and he also inserts `discount_percentage` = 99, although it actually should be 20 in this case.
 */
class PriceConversionBehavior extends Behavior {
    
}