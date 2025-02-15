<?php

namespace app\controllers;

use app\models\domain\PriceOfferRecord;
use app\models\domain\UnitOfGoodsRecord;
use app\models\price_offer\PriceOfferOnCategoryModel;
use app\models\price_offer\PriceOfferViaDiscountModel;
use app\models\price_offer\PriceOfferViaPriceModel;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

use OpenApi\Annotations as OA;
/**
 * @OA\PathItem(path="/api")
 */
class PriceOfferApiController extends BaseApiController
{
    public $modelClass = 'app\models\domain\PriceOfferRecord';

    /**
     * @OA\Get(
     *     path="/api/endpoint",
     *     @OA\Response(response="200", description="Get default action")
     * )
     * Here you specify `newPrice`, and then `discountPercentage` is calculated automatically according to that `newPrice`.
     * json example: {"unitOfGoodsId": 1, "newPrice": 5, "priorityRank": {"shift": true, "rank": 1}} (here `unitOfGoodsId`: 1 is danaida monarch)
     * @return void
     */
    public function actionCreateViaPrice()
    {
        $this->handleComplicatedRequest(
            PriceOfferViaPriceModel::class,
            true,
            function ($validatedModel) {
                if ($validatedModel->priorityRank) {
                    PriceOfferRecord::createViaPrice($validatedModel->unitOfGoodsId, $validatedModel->newPrice, $validatedModel->priorityRank->rank, $validatedModel->priorityRank->shift);
                } else {
                    PriceOfferRecord::createViaPrice($validatedModel->unitOfGoodsId, $validatedModel->newPrice);
                }
            },
            'Failed to create price offer'
        );
    }

    /**
     * @OA\Get(
     *      path="/profiles",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *     @OA\PathItem (
     *     ),
     * )
     */
    /*
     * Here you specify `discountPercentage`, and the app calculates `newPrice` according to that `discountPercentage`.
     * json example: {"unitOfGoodsId": 1, "discountPercentage": 5} (here 1 is danaida monarch)
     * @return void
     */
    public function actionCreateViaDiscountPercentage()
    {
        $this->handleComplicatedRequest(
            PriceOfferViaDiscountModel::class,
            true,
            function ($validatedModel) {
                if ($validatedModel->priorityRank) {
                    PriceOfferRecord::createViaDiscountPercentage($validatedModel->unitOfGoodsId, $validatedModel->discountPercentage, $validatedModel->priorityRank->rank, $validatedModel->priorityRank->shift);
                } else {
                    PriceOfferRecord::createViaDiscountPercentage($validatedModel->unitOfGoodsId, $validatedModel->discountPercentage);
                }
            },
            'Failed to create price offer. Probably discount percentage is too small or too big'
        );
    }

    /**
     * Creates price offers for each goods item, which has a `categoryName` category. E.g. "ORTHOPTERA SALE! 15% DISCOUNT ON ORTHOPTERA ". Important notice: you can specify only `discountPercentage` insomuch as `newPrice` can be not fitted for all goods items.
     * json example: {"categoryId": 1, "discountPercentage": 45}
     * @return void
     */
    public function actionCreateForCategory()
    {
        $this->handleComplicatedRequest(
            PriceOfferOnCategoryModel::class,
            false,
            function ($validatedModel) {
                PriceOfferRecord::createForCategory($validatedModel->categoryId, $validatedModel->discountPercentage);
            },
            'Failed to create price offers. Probably discount percentage is too small or too big'
        );
    }

    // public function create($goodsItemId, $otherOptions)
    // {
    //     // if ($withShift) {
    //     //     if (isAlreadyTaken($priorityRank)) {
    //     //         shiftPriorityRankBelow($priorityRank);
    //     //     }
    //     // } else {
    //     //     // without shift. throws exception when rank is being already taken
    //     // }
    // }

    // public function delete($whichOneToDelete)
    // {
    //     // the same thing with shift as in `create()` but in the other direction. when 1 rank is deleted having 1,2,3, then 2,3 become 1,2  
    // }

    // public function deleteForCategory($categoryName)
    // {
    //     // antonym of `createForCategory()`
    // }




}