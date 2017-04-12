<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\DiscountService;
use app\models\Order;

/**
 * This is the model class for table "discount".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $discount
 * @property integer $birthdate_before
 * @property integer $birthdate_after
 * @property integer $phone_exists
 * @property integer $phone_tail
 * @property string $gender
 * @property integer $date_start
 * @property integer $date_end
 *
 * @property DiscountService[] $discountServices
 */
class Discount extends \yii\db\ActiveRecord
{
    public $_services;    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discount';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    public function beforeSave($insert) {
        $fields = ['date_start', 'date_end'];
            
        foreach($fields as $field){
            if(isset($this->$field)){
                $time = \DateTime::createFromFormat( 'd.m.Y', $this->$field );
                $this->$field = $time->format('U');
            }
        }
        
        $this->gender = strlen($this->gender)==0 ? null : $this->gender;
        
        parent::beforeSave($insert);
        return true;
    }
    
    public function afterSave($insert, $changedAttributes)
    {       
        parent::afterSave($insert, $changedAttributes);        
        
        DiscountService::deleteAll('discount_id='.$this->id);
        foreach ($this->_services as $service) {
            $model = new DiscountService();
            $model->discount_id = $this->id;
            $model->service_id = $service;
            
            $model->save();
        }
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['discount', 'date_start'], 'required'],
            [['discount'], 'number', 'min'=>1, 'max'=>100],            
            [['birthdate_before', 'birthdate_after', 'phone_exists', 'created_at', 'updated_at'], 'integer'],           
            [['phone_tail'], 'match', 'pattern'=>'/^\d{4}$/i', 'message'=>'Ожидается 4 цифры'],
            [['gender'], 'string', 'max' => 10],
            ['date_start', 'compare', 'compareAttribute' => 'date_end', 'operator' => '<=', 
                'when'=>function($model){ return isset($model->date_end); },
                'whenClient' => "function (attribute, value) {
                    return ($('#discount-date_end').val().length > 0);
                }"                        
            ],
            ['date_end', 'compare', 'compareAttribute' => 'date_start', 'operator' => '>='],
            [['services','date_start', 'date_end'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'discount' => 'Скидка (%)',
            'birthdate_before' => 'Неделя до ДР',
            'birthdate_after' => 'Неделя после ДР',
            'phone_exists' => 'Есть телефон',
            'phone_tail' => 'Последние 4 цифры номера телефона',
            'gender' => 'Пол',
            'date_start' => 'Начало акции',
            'date_end' => 'Окончание акции',
            'services' => 'Услуги'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscountServices()
    {
        return $this->hasMany(DiscountService::className(), ['discount_id' => 'id']);
    }
    
    public function setServices($services){
        $this->_services = $services;
    }
    
    public function getServices()
    {
        return $this->hasMany(Service::className(), ['id' => 'service_id'])
            ->viaTable('discount_service', ['discount_id' => 'id']);
    }    
    
    public function getGender()
    {
        switch ($this->gender){
            case Order::GENDER_MALE:
                return 'Мужской';
            case Order::GENDER_FEMALE:
                return 'Женский';
        }
    }      
}
