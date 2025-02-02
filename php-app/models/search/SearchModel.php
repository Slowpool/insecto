<?php

namespace app\models\search;

use app\models\domain\GoodsCategoryRecord;
use yii\base\Model;

class SearchModel extends Model
{
    public ?string $searchText = null;
    /**
     * array of pairs like `'category name' => checked` (boolean value)
     * @var 
     */
    public ?array $categories = null;
    public ?bool $isAlive = null;
    public ?bool $isAvailable = null;
    public ?int $minPrice = null;
    public ?int $maxPrice = null;
    public function rules()
    {
        return [
            [['searchText', 'categories', 'isAlive', 'isAvailable', 'minPrice', 'maxPrice'], 'safe'],
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
            [
                ['categories'],
                'validateCategories',
                'when' => function ($categories) {
                    return $categories !== null;
                },
                'message' => 'Some category/categories you specified does/do not exist'
            ],
            // TODO validate that categories aren't repeated 
        ];
    }

    public function formName()
    {
        return '';
    }

    public function validateCategories($attribute, $params)
    {
        foreach ($this->categories as $categoryName => $checked) {
            // TODO error
            if (!GoodsCategoryRecord::exists($categoryName)) {
                return false;
            }
        }
        return true;
    }

    public function beforeLoad()
    {

    }

    /**
     * This method parses `categories` as array rather than string.
     * explanation: `localhost:8000/insects/dioptra/ortopetrpha/stick insects` => ['dioptra', 'ortopetrpha', 'stick insects']
     * @param mixed $data
     * @param mixed $formName
     * @return bool
     */
    public function load($data, $formName = null): bool
    {
        if (isset($data['categories'])) {
            $this->categories = array_fill_keys(explode('/', $data['categories']), true);
            unset($data['categories']);
        }
        parent::load($data, $formName);
        // i'm not sure it's correct to always return true, but actually this model's properties are optional and even when all properties are null, the model is valid. 
        return true;
    }
}