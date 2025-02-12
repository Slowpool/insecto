<?php

namespace app\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UnprocessableEntityHttpException;

abstract class BaseApiController extends \yii\rest\ActiveController
{
    /**
     * 
     * @param mixed $modelClass
     * @param bool $complicatedJsonInput if true, than input nested models are converted to models, otherwise to array
     * @param callable $businessLogicCallback
     * @param string $errorMessageForUser
     * @throws \yii\web\BadRequestHttpException
     * @throws \yii\web\ServerErrorHttpException
     * @return void
     */
    public function handleComplicatedRequest(mixed $modelClass, bool $complicatedJsonInput, callable $businessLogicCallback, string $errorMessageForUser)
    {
        if ($complicatedJsonInput) {
            $model = new $modelClass(['json' => Json::decode(Yii::$app->request->rawBody)]);
        }
        else {
            $model = new $modelClass;
            $model->load(Yii::$app->request->bodyParams, '');
        }
        if (!$model->validate()) {
            throw new UnprocessableEntityHttpException(implode(' ', $model->getErrorSummary(true)));
        }

        try {
            $businessLogicCallback($model);
        } catch (\yii\db\Exception $e) {
            Yii::error($e->getMessage(), 'db');
            throw new ServerErrorHttpException($errorMessageForUser);
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}