<?php

namespace app\controllers;

use app\models\domain\PriceOfferRecord;
use app\models\domain\UnitOfGoodsRecord;
use app\models\price_offer\PriceOfferViaDiscountModel;
use app\models\price_offer\PriceOfferViaPriceModel;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

class PriceOfferApiController extends BaseApiController
{
    public $modelClass = 'app\models\domain\PriceOfferRecord';

    /**
     * Here you specify `newPrice`, and the app calculates `discountPercentage` according to that `newPrice`.
     * json example: {"unitOfGoodsId": 1, "newPrice": 35} (here 1 is danaida monarch)
     * @return void
     */
    public function actionCreateViaPrice()
    {
        $this->handleComplicatedRequest(
            PriceOfferViaPriceModel::class,
            function ($validatedModel) {
                PriceOfferRecord::createViaPrice($validatedModel->unitOfGoodsId, $validatedModel->newPrice);
            },
            'Failed to create price offer'
        );
    }

    /**
     * Here you specify `discountPercentage`, and the app calculates `newPrice` according to that `discountPercentage`.
     * json example: {"unitOfGoodsId": 1, "discountPercentage": 5} (here 1 is danaida monarch)
     * @return void
     */
    public function actionCreateViaDiscountPercentage()
    {
        $this->handleComplicatedRequest(
            PriceOfferViaDiscountModel::class,
            function ($validatedModel) {
                PriceOfferRecord::createViaDiscountPercentage($validatedModel->unitOfGoodsId, $validatedModel->discountPercentage);
            },
            'Failed to create price offer. Probably it is impossible to create a price offer with such a small/big discount percentage'
        );
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
        } else {
            // without shift. throws exception when rank is being already taken
        }
    }

    public function delete($whichOneToDelete)
    {
        // the same thing with shift as in `create()` but in the other direction. when 1 rank is deleted having 1,2,3, then 2,3 become 1,2  
    }

    public function deleteForCategory($categoryName)
    {
        // antonym of `createForCategory()`
    }




}