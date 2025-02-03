<?php

namespace app\models\category;

use app\models\domain\GoodsCategoryRecord;
use yii\base\Model;

class CommonCategorizedFilter extends Model
{
    public ?bool $isAlive = null;
    public ?bool $isAvailable = null;
    public ?int $minPrice = null;
    public ?int $maxPrice = null;
    public function rules()
    {
        return [
            [['isAlive', 'isAvailable', 'minPrice', 'maxPrice'], 'safe'],
            [
                ['minPrice'],
                'compare',
                'compareAttribute' => 'maxPrice',
                'operator' => '<=',
                'when' => function ($model): bool {
                    return $model->maxPrice !== null;
                },
                'whenClient' => "function() {
                    var maxPrice = document.getElementById('maxprice');
                    return maxPrice.value != '';
                }",
                'message' => 'Minimum price must be lower than or equal to maximum price.'
            ],
            [
                ['maxPrice'],
                'compare',
                'compareAttribute' => 'minPrice',
                'operator' => '>=',
                'when' => function ($model): bool {
                    return $model->minPrice !== null;
                },
                'whenClient' => "function() {
                    var minPrice = document.getElementById('minprice');
                    return minPrice.value != '';
                }",
                'message' => 'Maximum price must be greater than or equal to minimum price.'
            ],
            [
                ['minPrice', 'maxPrice'],
                'compare',
                'compareValue' => 0,
                'operator' => '>=',
                'message' => 'Price border cannot be negative'
            ],
        ];
    }

    public function formName()
    {
        return '';
    }
}