<?php

namespace app\controllers;

use Yii;

use app\models\domain\PriceOfferRecord;
use app\models\domain\UnitOfGoodsRecord;

use app\models\API\price_offer\PriceOfferOnCategoryModel;
use app\models\API\price_offer\PriceOfferViaDiscountModel;
use app\models\API\price_offer\PriceOfferViaPriceModel;

use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

use OpenApi\Annotations\Server;

/**
 * @OA\Info(
 *    version="1.0",
 *    title="Price offer Api",
 *    description="Price offer Api. Using this Api you can manipulate the price offers of goods, creating, removing and deleting discounts. Notice, you can't update it - delete the old one and create the new one instead."
 * )
 */
class PriceOfferApiController extends BaseApiController
{
    public $modelClass = 'app\models\domain\PriceOfferRecord';

    /**
     * @OA\Post(
     *     path="/price-offer-api/create-via-price",
     *     summary="Create price offer via price",
     *     description="New price offer will be created with correspondent `discountPercentage`, which is calculated automatically using received `newPrice`. You can specify `rankPriority` for that price offer (this attribute allows to display specific goods items in specified order, on main page in the 'sale' block). If you specified `shift` as 'false' for this `rankPriority`, then this endpoint will give a error in case some another price offer with the same priority rank already exists. Alternatively, you can specify it as 'true', which changes the behavior of endpoint in the previously described case: all ranks, which are less than or equal to the specified `rank` (except those, which can remain unchanged) will be moved down.
     * When price offer already exists for specified `unitOfGoodsId`, this endpoint removes it and creates a new one.
     * If you want to create a price offer specifying discount percentage, use '/create-via-discount-percentage'",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             ref="#/components/schemas/PriceOfferViaPriceModel",
     *             example="{""unitOfGoodsId"": 1, ""newPrice"": 10, ""priorityRank"": {""shift"": true, ""rank"": 1}}"
     *         )
     *     ),
     *     @OA\Parameter(
     *         in="header",
     *         name="Content-Length",
     *         description="The length of the request body (optional, auto-calculated)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="New price offer is created successfully."
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="JSON parser can't read the request body. Ensure you attached JSON entity as a request body and it's syntax is correct."
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Goods item, for which the price offer is being created, does not exist. Ensure that unit of goods with `unitOfGoodsId` id does exist."
     *     ),
     *     @OA\Response(
     *         response="409",
     *         description="Specified rank `priorityRank` is already taken and specified `shiftPriority` property is 'false'. It was made to keep user aware about already existing price offer with specified priority rank. Otherwise, when you don't care that other price offer might be moved down, set it to 'true' to shift priority when the rank is already taken."
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Some model validation errors do not allow to create new price offer. Ensure JSON body model is correct from the point of view of the subject area."
     *     ),
     * )
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

    // /*
    //  * Here you specify `discountPercentage`, and the app calculates `newPrice` according to that `discountPercentage`.
    //  * json example: {"unitOfGoodsId": 1, "discountPercentage": 5} (here 1 is danaida monarch)
    //  * @return void
    //  */
    // /**
    //  * @OA\Get(
    //  *      path="/profiles",
    //  *      @OA\Response(
    //  *          response=200,
    //  *          description="Successful operation",
    //  *      ),
    //  *     @OA\PathItem(path="/api1")
    //  * )
    //  * /**
    //  */
    // public function actionCreateViaDiscountPercentage()
    // {
    //     $this->handleComplicatedRequest(
    //         PriceOfferViaDiscountModel::class,
    //         true,
    //         function ($validatedModel) {
    //             if ($validatedModel->priorityRank) {
    //                 PriceOfferRecord::createViaDiscountPercentage($validatedModel->unitOfGoodsId, $validatedModel->discountPercentage, $validatedModel->priorityRank->rank, $validatedModel->priorityRank->shift);
    //             } else {
    //                 PriceOfferRecord::createViaDiscountPercentage($validatedModel->unitOfGoodsId, $validatedModel->discountPercentage);
    //             }
    //         },
    //         'Failed to create price offer. Probably discount percentage is too small or too big'
    //     );
    // }

    // /*
    //  * Creates price offers for each goods item, which has a `categoryName` category. E.g. "ORTHOPTERA SALE! 15% DISCOUNT ON ORTHOPTERA ". Important notice: you can specify only `discountPercentage` insomuch as `newPrice` can be not fitted for all goods items.
    //  * json example: {"categoryId": 1, "discountPercentage": 45}
    //  * @return void
    //  */
    // /**
    //  * @OA\Get(
    //  *      path="/profiles",
    //  *      @OA\Response(
    //  *          response=200,
    //  *          description="Successful operation",
    //  *      ),
    //  *     @OA\PathItem(path="/api1")
    //  * )
    //  * /**
    //  */
    // public function actionCreateForCategory()
    // {
    //     $this->handleComplicatedRequest(
    //         PriceOfferOnCategoryModel::class,
    //         false,
    //         function ($validatedModel) {
    //             PriceOfferRecord::createForCategory($validatedModel->categoryId, $validatedModel->discountPercentage);
    //         },
    //         'Failed to create price offers. Probably discount percentage is too small or too big'
    //     );
    // }

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