<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estimate".
 *
 * @property string $id
 * @property string $seller_name
 * @property string $client_name
 * @property string $ruc
 * @property string $total
 * @property string $tax
 * @property string $created
 * @property string $updated
 *
 * @property ProductEstimate[] $productEstimates
 * @property Product[] $products
 * @property PromotionEstimate[] $promotionEstimates
 * @property Promotion[] $promotions
 */
class Estimate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estimate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['seller_name', 'client_name', 'ruc', 'total', 'tax'], 'required'],
            [['total', 'tax'], 'number'],
            [['created', 'updated'], 'safe'],
            [['seller_name', 'client_name', 'ruc'], 'string', 'max' => 45],
            [['ruc'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'seller_name' => Yii::t('app', 'Seller Name'),
            'client_name' => Yii::t('app', 'Client Name'),
            'ruc' => Yii::t('app', 'Ruc'),
            'total' => Yii::t('app', 'Total'),
            'tax' => Yii::t('app', 'Tax'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductEstimates()
    {
        return $this->hasMany(ProductEstimate::className(), ['estimate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable('product_estimate', ['estimate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromotionEstimates()
    {
        return $this->hasMany(PromotionEstimate::className(), ['estimate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromotions()
    {
        return $this->hasMany(Promotion::className(), ['id' => 'promotion_id'])->viaTable('promotion_estimate', ['estimate_id' => 'id']);
    }
}
