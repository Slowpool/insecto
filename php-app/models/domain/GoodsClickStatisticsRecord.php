<?php

namespace app\models\domain;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "goods_click_statistics".
 *
 * @property string $id GUID. it could have been BIGINT, whose size would be sufficient for an Amazon-like website for the next 1.5kk years (there's a limit!), whereas guid (with regular cleaning) implies an endless period of use (because it doesn't has AUTO_INCREMENT).
 * @property int $unit_of_goods_id
 * @property string $created_at
 *
 * @property UnitOfGoodsRecord $unitOfGoods
 */
class GoodsClickStatisticsRecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods_click_statistics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_of_goods_id'], 'required'],
            [['unit_of_goods_id'], 'integer'],
            [['created_at'], 'safe'],
            [
                ['unit_of_goods_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => UnitOfGoodsRecord::class,
                'targetAttribute' => ['unit_of_goods_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            // 'id' => 'ID',
            // 'unit_of_goods_id' => 'Unit of goods ID',
            // 'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[UnitOfGoods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnitOfGoods()
    {
        return $this->hasOne(UnitOfGoodsRecord::class, ['id' => 'unit_of_goods_id']);
    }

    public static function registerClick(int $unitOfGoodsId, bool $runValidation): void
    {
        $record = new self(['unit_of_goods_id' => $unitOfGoodsId]);
        if (!$record->save($runValidation)) {
            // TODO such a small piece of information
            Yii::error("Failed to register click for goods item with id $unitOfGoodsId", 'db');
        }
    }

    /** This method removes outdated clicks. */
    public static function clear()
    {
        $click_expiration_measure = CLICK_EXPIRATION_MEASURE;
        self::deleteAll(['>=', new Expression("TIMESTAMPDIFF($click_expiration_measure, [[created_at]], CURRENT_TIMESTAMP)"), CLICK_EXPIRATION]);
    }
}
