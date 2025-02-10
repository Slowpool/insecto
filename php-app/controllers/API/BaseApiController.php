<?php

namespace app\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

abstract class BaseApiController extends \yii\rest\ActiveController
{
    public function handleComplicatedRequest(mixed $modelClass, callable $businessLogicCallback, string $errorMessageForUser)
    {
        $model = new $modelClass;
        if (!$model->load(Yii::$app->request->bodyParams, '') || !$model->validate()) {
            throw new BadRequestHttpException(implode(' ', $model->getErrorSummary(true)));
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