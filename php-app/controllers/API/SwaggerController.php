<?php

namespace app\controllers;

use Yii;

// use function \OpenApi\Generator\scan;

use OpenApi\Annotations as OA;
/**
 * @OA\PathItem(path="/api")
 */
class SwaggerController extends \yii\web\Controller
{
    /**
     * @OA\PathItem(path="/api")
     */
    public function actionGo1()
    {
        // require("../vendor/autoload.php");
        $openApi = \OpenApi\Generator::scan([Yii::getAlias('@app')]);
        $file = Yii::getAlias('@app/web/api-doc/swagger.yaml');
        $handle = fopen($file, 'wb');
        fwrite($handle, $openApi->toYaml());
        fclose($handle);
        return;
    }
    /**
     * @OA\PathItem(path="/api")
     */
    public function actionGo2()
    {
        // require("../vendor/autoload.php");
        $openApi = \OpenApi\Generator::scan([Yii::getAlias('@app/controllers/API')]);
        $this->response->format = 'application/yaml';
        return $openApi->toYaml();
    }

}