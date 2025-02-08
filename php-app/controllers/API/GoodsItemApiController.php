<?php

namespace app\controllers;

use app\models\domain\UnitOfGoodsRecord;

class GoodsItemApiController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\domain\UnitOfGoodsRecord';

    /**
     * E.g. you had a 3 remaining mosquitoes. After receiving 5 more, you would have 8 mosquitoes.
     * @param mixed $unitOfGoodsId
     * @param mixed $numberOfReceived
     * @return void
     */
    public function goodsReception($unitOfGoodsId, $numberOfReceived)
    {
        if ($numberOfReceived <= 0) {
            throw new \Exception('You should receive natural number of goods items, not 0');
        }
        incrementNumberOfRemaining($unitOfGoodsId, $numberOfReceived);
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

    public function createSeveral(array $unitsOfGoods) {
        beginTransaction();
        try {
            foreach($unitsOfGoods as $goodsItem) {
                create($goodsItem);
            }
        }
        catch (\Exception $e) {
            // rollback
        }
    }

    public function stuffWithPictures() {
        // TODO requires picture binded to db entity 
    }

}