<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "promotion".
 *
 * @property string $id
 * @property string $description
 * @property string $deduction
 *
 * @property ProductPromotion[] $productPromotions
 * @property Product[] $products
 * @property PromotionEstimate[] $promotionEstimates
 * @property Estimate[] $estimates
 */
class Promotion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promotion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'deduction', 'total'], 'required'],
            [['deduction', 'total'], 'number'],
            [['description'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Descripción',
            'deduction' => '% Descuento',
            'total' => 'Total'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductPromotions()
    {
        return $this->hasMany(ProductPromotion::className(), ['promotion_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable('product_promotion', ['promotion_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromotionEstimates()
    {
        return $this->hasMany(PromotionEstimate::className(), ['promotion_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstimates()
    {
        return $this->hasMany(Estimate::className(), ['id' => 'estimate_id'])->viaTable('promotion_estimate', ['promotion_id' => 'id']);
    }
}
