<?php

namespace app\models\domain;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "goods_category".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 *
 * @property UnitOfGoodsRecord[] $unitOfGoods
 */
class GoodsCategoryRecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'slug'], 'string', 'max' => 50],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[UnitOfGoods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnitOfGoods()
    {
        return $this->hasMany(UnitOfGoodsRecord::class, ['category_id' => 'id']);
    }

    public static function getNames(): array
    {
        return array_column(
            self::find()
                ->select(['name'])
                ->asArray()
                ->all(),
            'name'
        );
    }

    public static function exists(string $name): bool
    {
        return self::find()
            ->where(['name' => $name])
            ->exists();
    }

    public static function getIds(array $categories): array
    {
        return array_column(
            self::find()
                ->select(['id'])
                ->where(['name' => $categories])
                ->asArray()
                ->all(),
            'id'
        );
    }
}
