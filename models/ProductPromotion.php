<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_promotion".
 *
 * @property string $product_id
 * @property string $promotion_id
 * @property integer $quantity
 * @property string $price
 *
 * @property Product $product
 * @property Promotion $promotion
 */
class ProductPromotion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_promotion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'promotion_id', 'quantity', 'price'], 'required'],
            [['product_id', 'promotion_id', 'quantity'], 'integer'],
            [['price'], 'number'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['promotion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Promotion::className(), 'targetAttribute' => ['promotion_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Producto',
            'promotion_id' => 'Paquete',
            'quantity' => 'Cantidad',
            'price' => 'Precio $',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromotion()
    {
        return $this->hasOne(Promotion::className(), ['id' => 'promotion_id']);
    }
}
