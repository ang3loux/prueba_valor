<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estimate".
 *
 * @property string $id
 * @property string $code
 * @property string $seller_name
 * @property string $client_name
 * @property string $ruc
 * @property string $total
 * @property string $tax
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
            [['code', 'seller_name', 'client_name', 'ruc', 'total', 'tax'], 'required'],
            [['total', 'tax'], 'number'],
            [['code'], 'string', 'max' => 20],
            [['seller_name', 'client_name', 'ruc'], 'string', 'max' => 45],
            [['code'], 'unique'],
            [['ruc'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Código',
            'seller_name' => 'Nombre del vendedor',
            'client_name' => 'Nombre del cliente',
            'ruc' => 'RUC',
            'total' => 'Total $',
            'tax' => '% Impuesto',
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
