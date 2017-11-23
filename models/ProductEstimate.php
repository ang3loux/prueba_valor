<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_estimate".
 *
 * @property string $product_id
 * @property string $estimate_id
 * @property integer $quantity
 * @property string $price
 *
 * @property Estimate $estimate
 * @property Product $product
 */
class ProductEstimate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_estimate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'estimate_id', 'quantity', 'price'], 'required'],
            [['product_id', 'estimate_id', 'quantity'], 'integer'],
            [['price'], 'number'],
            [['estimate_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estimate::className(), 'targetAttribute' => ['estimate_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'estimate_id' => 'Estimate ID',
            'quantity' => 'Quantity',
            'price' => 'Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstimate()
    {
        return $this->hasOne(Estimate::className(), ['id' => 'estimate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
