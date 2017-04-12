<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "discount_service".
 *
 * @property integer $id
 * @property integer $discount_id
 * @property integer $service_id
 *
 * @property Discount $discount
 */
class DiscountService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discount_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['discount_id', 'service_id'], 'required'],
            [['discount_id', 'service_id'], 'integer'],
            [['discount_id'], 'exist', 'skipOnError' => true, 'targetClass' => Discount::className(), 'targetAttribute' => ['discount_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'discount_id' => 'Discount ID',
            'service_id' => 'Service ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscount()
    {
        return $this->hasOne(Discount::className(), ['id' => 'discount_id']);
    }
}
