<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property string $id
 * @property string $description
 * @property string $type
 * @property string $price
 * @property string $created
 * @property string $updated
 *
 * @property ProductEstimate[] $productEstimates
 * @property Estimate[] $estimates
 * @property ProductPromotion[] $productPromotions
 * @property Promotion[] $promotions
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'type', 'price'], 'required'],
            [['price'], 'number'],
            [['created', 'updated'], 'safe'],
            [['description', 'type'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'description' => Yii::t('app', 'Description'),
            'type' => Yii::t('app', 'Type'),
            'price' => Yii::t('app', 'Price'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductEstimates()
    {
        return $this->hasMany(ProductEstimate::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstimates()
    {
        return $this->hasMany(Estimate::className(), ['id' => 'estimate_id'])->viaTable('product_estimate', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductPromotions()
    {
        return $this->hasMany(ProductPromotion::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromotions()
    {
        return $this->hasMany(Promotion::className(), ['id' => 'promotion_id'])->viaTable('product_promotion', ['product_id' => 'id']);
    }
}
