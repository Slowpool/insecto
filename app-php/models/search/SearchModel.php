<?php

namespace app\models\search;

use app\models\domain\GoodsCategoryRecord;
use yii\base\Model;

class SearchModel extends Model
{
    public ?string $searchText = null;
    /**
     * `'category name' => checked` (boolean value)
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
            [
                ['minPrice'],
                'compare',
                'compareAttribute' => 'maxPrice',
                'operator' => '<=',
                'when' => function ($minPrice) {
                    return $minPrice !== null;
                },
                'message' => 'Minimal price must be lower than or equal to maximum price.'
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

    public function validateCategories($attribute, $params)
    {
        foreach ($this->categories as $category) {
            // TODO error
            if (!GoodsCategoryRecord::exists($category)) {
                return false;
            }
        }
        return true;
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


    // public function setDefaultValues()
    // {
    //     $this->searchText = '';
    //     $this->categories = [];
    //     $this->isAlive = false;
    //     $this->isAvailable = false;
    //     $this->minPrice = 0;
    //     $this->maxPrice = PHP_INT_MAX;
    // }
}