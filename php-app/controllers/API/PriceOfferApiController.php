<?php

namespace app\controllers;

class PriceOfferApiController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\domain\PriceOfferRecord';

    /**
     * Here you specify `newPrice`, and program calculates `discountPercentage` according to that `newPrice`
     * @return void
     */
    public function updateViaNewPrice($priceOfferId, $newPrice)
    {
        
    }

    /**
     * Here you specify `discountPercentage`, and the program calculates `newPrice` according to that `discountPercentage`
     * @return void
     */
    public function updateViaDiscountPercentage()
    {

    }

    /**
     * Alternative to `updateViaNewPrice()` and `updateViaDiscountPercentage()`.
     * @return void
     */
    // TODO Should it be implemented or should it be divided into `updateViaNewPrice()` and `updateViaDiscountPercentage()`?
    public function update($priceOfferId, $newPrice, $discountPercentage, $priorityRank)
    {
        if ($newPrice !== null && $discountPercentage !== null) {
            // to prevent inconsistency like `price` = 100, `discountPercentage` = 50, newPrice = 99
            throw new \Exception('Pick either `newPrice` or `discountPercentage`, not both');
        }

        if ($newPrice) {
            $discountPercentage = calculateDiscountPercentage($price, $newPrice);
        } elseif ($discountPercentage) {
            $newPrice = calculateNewPrice($price, $discountPercentage);
        }

        // update
    }

    /**
     * Creates price offers for each goods item, which has a `categoryName` category. E.g. "ORTHOPTERA SALE! 15% DISCOUNT ON ORTHOPTERA ". Important notice: you can specify only `discountPercentage` insomuch as `newPrice` can be not fitted for all goods items. 
     * @return void
     */
    public function createForCategory($categoryName, $discountPercentage)
    {
        $unitOfGoodsRecords = getWithCategory($categoryName);
        foreach ($unitOfGoodsRecords as $record) {
            createPriceOffer($record->id, $discountPercentage);
        }
    }

    public function create($goodsItemId, $priorityRank, bool $withShift, $otherOptions)
    {
        if ($withShift) {
            if (isAlreadyTaken($priorityRank)) {
                // e.g.: existing priority ranks: 1, 2, 3. Received $priorityRank value: 1. This method shifts existings priority ranks to 2,3,4 and sets $goodsItemId price offer priority rank = $priorityRank (which is 1)
                shiftPriorityRankBelow($priorityRank);
            }
        }
        else {
            // without shift. throws exception when rank is being already taken
        }
    }
    
    public function delete($whichOneToDelete) {
        // the same thing with shift as in `create()` but in the other direction. when 1 rank is deleted having 1,2,3, then 2,3 become 1,2  
    }

    public function deleteForCategory($categoryName) {
        // antonym of `createForCategory()`
    }




}