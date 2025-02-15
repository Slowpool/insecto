<?php

namespace app\controllers;


/**
 * @OA\PathItem(path="/api")
 */
class CategoryApiController extends BaseApiController
{
    public $modelClass = 'app\models\domain\GoodsCategoryRecord';
    

}