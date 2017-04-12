<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'Гемотест';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Тестовое задание</h1>

        <p class="lead">Стяжкина Марина.</p>

        <p>
            <?= Html::a('Заказ услуг', ['order/create'], ['class' => 'btn btn-lg btn-success']) ?>            
        </p>
    </div>

    <div class="body-content">

        <div class="row">

        </div>

    </div>
</div>
