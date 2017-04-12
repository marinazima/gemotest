<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Order;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DiscountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Скидки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discount-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить скидку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'discount',
            ['attribute'=>'birthdate_before',
            'format'=>'boolean',
            'filter' => ['0' => 'Нет', '1' =>'Да'],
            'header'=>'Неделя<br>до ДР'
            ],
            ['attribute'=>'birthdate_after',
            'format'=>'boolean',
            'filter' => ['0' => 'Нет', '1' =>'Да'],
            'header'=>'Неделя<br>после ДР'
            ],
            ['attribute'=>'phone_exists',
            'format'=>'boolean',
            'filter' => ['0' => 'Нет', '1' =>'Да'],
            'label' => 'Телефон',            
            ],
            ['attribute'=>'phone_tail',
            'header'=>'Последние 4<br>цифры'
            ],
            [
                'attribute'=>'gender', 
                'filter'=>Order::getGenders(),   
                'value'=>function($data){
                    return $data->getGender();
                }
            ],
            ['attribute'=>'order_services',
                'value'=>function($data){
                    return implode('<br />',ArrayHelper::getColumn($data->services,'name'));
                },
                'format'=>'html'
            ],                    
            ['attribute'=>'date_start', 
            'format' =>  ['datetime', 'php:d.m.y'],
            'options' => ['width' => '100']
            ],
            ['attribute'=>'date_end', 
            'format' =>  ['datetime', 'php:d.m.y'],
            'options' => ['width' => '100']
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
