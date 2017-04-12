<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить заказ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'discount',
            ['attribute'=>'created_at', 'format'=>['datetime', 'php:d.m.y H:i:s']],
            ['attribute'=>'updated_at', 'format'=>['datetime', 'php:d.m.y H:i:s']],
            'customer',
            ['attribute'=>'birthdate', 'format'=>['datetime', 'php:d.m.y']],
            'phone',
            ['attribute'=>'gender','value'=>$model->getGender()],
            ['attribute'=>'services', 
            'value'=>implode('<br />', ArrayHelper::getColumn($model->services,'name')),
            'format'=>'html'
            ],
            //['attribute'=>'birthday', 'value'=>$model->getBirthday(), 'format'=>['datetime', 'dd.MM.Y']]
        ],
    ]) ?>

</div>
