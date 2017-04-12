<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Услуги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать услугу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute'=>'id','options' => ['width'=>'100']],
            'name',            
            ['attribute'=>'created_at', 
            'format' =>  ['datetime', 'php:d.m.y H:i:s'],
            'options' => ['width' => '200']
            ],
            ['attribute'=>'updated_at', 
            'format' =>  ['datetime', 'php:d.m.y H:i:s'],
            'options' => ['width' => '200']
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],    
    ]); ?>
</div>
