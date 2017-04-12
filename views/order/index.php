<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Order;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать заказ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute'=>'id','options' => ['width'=>'70']],           
            ['attribute'=>'created_at', 
            'format' =>  ['datetime', 'php:d.m.y H:i:s'],
            'options' => ['width' => '100']
            ],
            'customer',
            ['attribute'=>'birthdate', 
            'format' =>  ['datetime', 'php:d.m.y'],
            'options' => ['width' => '70'],
            'header'=>'Дата<br>рождения'
            ],
            [
                'attribute'=>'gender', 
                'filter'=>Order::getGenders(),   
                'value'=>function($data){
                    return $data->getGender();
                },
                'options' => ['width' => '70'],                
            ],
            ['attribute'=>'phone', 
            'options' => ['width' => '120']
            ],
            [
                'attribute'=>'order_services',
                'value'=>function($data){
                    return implode('<br />',ArrayHelper::getColumn($data->services,'name'));
                },
                'format'=>'html'
            ],            
            ['attribute'=>'discount','options' => ['width'=>'70']],           
                        
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>    
</div>
