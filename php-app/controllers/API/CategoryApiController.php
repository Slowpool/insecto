<?php

namespace app\controllers;

use OpenApi\Annotations as OA;
/**
 * @OA\PathItem(path="/api")
 */
class CategoryApiController extends BaseApiController
{
    public $modelClass = 'app\models\domain\GoodsCategoryRecord';
    

}