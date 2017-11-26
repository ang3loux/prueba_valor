<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "promotion_estimate".
 *
 * @property string $promotion_id
 * @property string $estimate_id
 * @property string $price
 *
 * @property Estimate $estimate
 * @property Promotion $promotion
 */
class PromotionEstimate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promotion_estimate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['promotion_id', 'estimate_id', 'price'], 'required'],
            [['promotion_id', 'estimate_id'], 'integer'],
            [['price'], 'number'],
            [['estimate_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estimate::className(), 'targetAttribute' => ['estimate_id' => 'id']],
            [['promotion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Promotion::className(), 'targetAttribute' => ['promotion_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'promotion_id' => 'Paquete',
            'estimate_id' => 'Cotización',
            'price' => 'Precio',
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
    public function getPromotion()
    {
        return $this->hasOne(Promotion::className(), ['id' => 'promotion_id']);
    }
}
