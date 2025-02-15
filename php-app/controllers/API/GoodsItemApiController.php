<?php

namespace app\controllers;

use app\models\domain\UnitOfGoodsRecord;
use app\models\goods_item\GoodsReceptionModel;
use app\models\goods_item\GoodsDiedModel;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;


/**
 * @OA\PathItem(path="/api")
 */
class GoodsItemApiController extends BaseApiController
{
    public $modelClass = 'app\models\domain\UnitOfGoodsRecord';

    /**
     * E.g. you had a 3 remaining mosquitoes. After receiving 5 more, you would have 8 mosquitoes.
     * json example: {"unitOfGoodsId": 1, "numberOfReceived": 5}
     * @return void
     */
    public function actionGoodsReception()
    {
        $this->handleComplicatedRequest(
            GoodsReceptionModel::class,
            false,
            function ($validatedModel) {
                UnitOfGoodsRecord::incrementNumberOfRemaining($validatedModel->unitOfGoodsId, $validatedModel->numberOfReceived);
            },
            'Failed to save updated goods item'
        );
    }

    /**
     * E.g. you have 10 alive spiders as a unitOfGoodsRecord. You specify $numberOfDied = 3 and method does this: the original unitOfGoodsRecord with these spiders becomes as 7 alive spiders, and new record with 3 the same died spiders is created with price reduction.
     * When all insects in record died, then this record just gets assigned isAlive = false and gets price reduction.
     * json example: {"unitOfGoodsId": 1, "numberOfDied": 1, "sellDied": true}
     * @return void
     */
    public function actionRegisterAsDied()
    {
        $this->handleComplicatedRequest(
            GoodsDiedModel::class,
            false,
            function ($validatedModel) {
                UnitOfGoodsRecord::died($validatedModel->unitOfGoodsId, $validatedModel->numberOfDied, $validatedModel->sellDied);
            },
            'Failed to save changes'
        );
    }

    // public function createSeveral(array $unitsOfGoods)
    // {
    //     // TODO implement
    //     beginTransaction();
    //     try {
    //         foreach ($unitsOfGoods as $goodsItem) {
    //             create($goodsItem);
    //         }
    //     } catch (\Exception $e) {
    //         // rollback
    //     }
    // }

    // public function stuffWithPictures()
    // {
    //     // TODO implement
    //     // TODO requires picture binded to db entity 
    // }

}