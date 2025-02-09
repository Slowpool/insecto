<?php

namespace app\controllers;

use app\models\domain\UnitOfGoodsRecord;
use app\models\goods_item\GoodsReceptionModel;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

class GoodsItemApiController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\domain\UnitOfGoodsRecord';

    /**
     * E.g. you had a 3 remaining mosquitoes. After receiving 5 more, you would have 8 mosquitoes.
     * @param mixed $unitOfGoodsId
     * @param mixed $numberOfReceived
     * @return void
     */
    // The only one method i have implemented.
    public function actionGoodsReception()
    {
        $model = new GoodsReceptionModel;
        // TODO serious issues with model validation.
        if (!$model->load(Yii::$app->request->bodyParams, '') || !$model->validate()) {
            throw new BadRequestHttpException(implode(' ', $model->getErrorSummary(true)));
        }

        try {
            UnitOfGoodsRecord::incrementNumberOfRemaining($model->unitOfGoodsId, $model->numberOfReceived);
        } catch (\Exception $e) {
            Yii::error($e->getMessage(), 'db');
            throw new ServerErrorHttpException('Failed to save updated goods item');
        }
    }

    /**
     * E.g. you have 10 alive spiders as a unitOfGoodsRecord. You specify $numberOfDied = 3 and method does this: the original unitOfGoodsRecord with these spiders becomes as 7 alive spiders, and new record with 3 the same died spiders is created with -90% price.
     * When all insects in record died, then this record just gets assigned isAlive = false and gets -90% price.
     * @param mixed $unitOfGoodsId
     * @param mixed $numberOfDied
     * @return void
     */
    public function registerAsDied($unitOfGoodsId, $numberOfDied)
    {
        $record = findById($unitOfGoodsId);
        // all died
        if ($record->numberOfRemaining == $numberOfDied) {

            $record->alive = false;
            // -90% when it dies.
            // notice: it is not a discount.
            $record->price = $record->price * 0.1;
            $record->update();
        }
        // some part died
        else {
            $record->numberOfRemaining -= $numberOfDied;

            $diedInsectRecord = new UnitOfGoodsRecord;
            $diedInsectRecord = copyValues($record); // except id ofc
            $diedInsectRecord->numberOfRemaining = $numberOfDied;
            $diedInsectRecord->price = $diedInsectRecord->price * 0.1;
            $diedInsectRecord->save();
        }
    }

    public function createSeveral(array $unitsOfGoods)
    {
        beginTransaction();
        try {
            foreach ($unitsOfGoods as $goodsItem) {
                create($goodsItem);
            }
        } catch (\Exception $e) {
            // rollback
        }
    }

    public function stuffWithPictures()
    {
        // TODO requires picture binded to db entity 
    }

}