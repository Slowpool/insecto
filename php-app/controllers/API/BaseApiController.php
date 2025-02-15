<?php

namespace app\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\ConflictHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UnprocessableEntityHttpException;


abstract class BaseApiController extends \yii\rest\ActiveController
{
    /**
     * @param string $modelClass
     * @param bool $complicatedJsonInput if true, than input nested models are converted to models, otherwise to array
     * @param callable $businessLogicCallback
     * @param string $errorMessageForUser
     * @throws BadRequestHttpException
     * @throws ServerErrorHttpException
     * @throws UnprocessableEntityHttpException
     * @return void
     */
    public function handleComplicatedRequest(string $modelClass, bool $complicatedJsonInput, callable $businessLogicCallback, string $errorMessageForUser)
    {
        if ($complicatedJsonInput) {
            try {
                $model = new $modelClass(['json' => Json::decode(Yii::$app->request->rawBody)]);
            } catch (\yii\base\InvalidArgumentException $e) {
                throw new BadRequestHttpException("Failed to parse an entity from body");
            }
        } else {
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
            switch ($e->getCode()) {
                case 409:
                    throw new ConflictHttpException($e->getMessage());
                case 422:
                default:
                    throw new UnprocessableEntityHttpException($e->getMessage());
            }
        }
    }
}