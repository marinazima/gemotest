<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\OrderService;
use app\models\Discount;
use \yii\db\Expression;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $customer
 * @property integer $birthdate
 * @property string $phone
 * @property string $gender
 * @property string $discount
 *
 * @property OrderService[] $orderServices
 */
class Order extends \yii\db\ActiveRecord
{
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
     
    public $_services;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
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
        if(isset($this->birthdate) && !(is_numeric($this->birthdate) && (int)$this->birthdate == $this->birthdate) ){
            $time = \DateTime::createFromFormat( 'd.m.Y', $this->birthdate );
            $this->birthdate = $time->format('U');
        }
        
        $this->phone = strlen($this->phone)==0 ? null : $this->phone;

        parent::beforeSave($insert);
        return true;
    }
    
    public function afterSave($insert, $changedAttributes)
    {       
        parent::afterSave($insert, $changedAttributes);        
        
        OrderService::deleteAll('order_id='.$this->id);
        foreach ($this->_services as $service) {
            $model = new OrderService();
            $model->order_id = $this->id;
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
            [['customer', 'birthdate', 'gender'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            //[['discount'], 'number'],
            [['customer'], 'string', 'max' => 500],
            [['phone'], 'string', 'max' => 12],
            [['gender'], 'string', 'max' => 10],
            [['services', 'birthdate', 'discount'], 'safe']
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
            'customer' => 'Заказчик',
            'birthdate' => 'Дата рождения',
            'phone' => 'Телефон',
            'gender' => 'Пол',
            'discount' => 'Скидка (%)',
            'services' => 'Услуги'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderServices()
    {
        return $this->hasMany(OrderService::className(), ['order_id' => 'id']);
    }
    
    public function setServices($services){
        $this->_services = $services;
    }
    
    public function getServices()
    {
        return $this->hasMany(Service::className(), ['id' => 'service_id'])
            ->viaTable('order_service', ['order_id' => 'id']);
    } 
 
    public function getGender()
    {
        switch ($this->gender){
            case self::GENDER_MALE:
                return 'Мужской';
            case self::GENDER_FEMALE:
                return 'Женский';
        }
    }    

    /**
     * @return array genders for dropdown controls
     */     
    public static function getGenders(){
        return [self::GENDER_MALE=>'Мужской', self::GENDER_FEMALE=>'Женский'];
    }   

    public function getBirthday($format=null){
        $year = date('Y');
        $month = date('m',$this->birthdate);
        $day = date('d',$this->birthdate);
        
        $birthday = \DateTime::createFromFormat('Y-m-d', $year.'-'.$month.'-'.$day);
        
        return isset($format) ? $birthday->format($format) : $birthday->format('U');
    }
    
    public function getDiscount(){
        $birthday = $this->getBirthday('Y-m-d');
        $today = strtotime('now');
        
        $query = Discount::find()
                ->joinWith('discountServices',true,'INNER JOIN')
                ->distinct();
        
        if(isset($this->_services)){ 
            $query->andWhere(['in', 'discount_service.service_id', $this->_services]);
        }

        //week before birthday
        $query->andWhere(['or',
            ['discount.birthdate_before'=>0],
            ['and',
                ['discount.birthdate_before'=>1],
                new Expression( '1='.( ($today>=strtotime($birthday.' -1 week') && $today<=strtotime($birthday)) ? 1 : 0 ) )
            ],
            ['discount.birthdate_after'=>0],
            ['and',
                ['discount.birthdate_after'=>1],
                new Expression( '1='.( ($today<=strtotime($birthday) && $today>=strtotime($birthday.' +1 week')) ? 1 : 0 ) )
            ]            
        ]);
        
        //phone exists
        $query->andWhere(['or',
            ["discount.phone_exists"=>0],
            ['and',
                ['discount.phone_exists'=>1],
                new Expression('1='.(isset($this->phone)?1:0))
            ]
        ]);        
        
        //phone tail
        if(isset($this->phone)){
            $query->andWhere(['or',
                ['discount.phone_tail'=>null],
                ['discount.phone_tail'=>substr($this->phone,-4)]
            ]);
        }        

        //gender
        $query->andWhere(['or',
            ['discount.gender'=>null],
            ['discount.gender'=>$this->gender]
        ]);

        //date start
        $query->andWhere(['<=','discount.date_start',$today]);
        
        //date_end
        $query->andWhere(['or',
            ['discount.date_end'=>null],
            ['>=','discount.date_end',$today]
        ]);
        
        $query->orderBy(['discount.discount'=>SORT_DESC]);

        //var_dump($query->createCommand()->getRawSql());        
        
        $discount = $query->one();

        //var_dump($discount ? $discount->discount : 0);
        
        return $discount ? $discount->discount : 0;
    }
}
