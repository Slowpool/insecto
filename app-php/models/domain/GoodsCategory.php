<?php

namespace app\models\domain;

use Yii;

/**
 * This is the model class for table "goods_category".
 *
 * @property int $id
 * @property string $name
 *
 * @property UnitOfGoods[] $unitOfGoods
 */
class GoodsCategory extends \yii\db\ActiveRecord
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
            [['name'], 'string', 'max' => 50],
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
        return $this->hasMany(UnitOfGoods::class, ['category_id' => 'id']);
    }
}
