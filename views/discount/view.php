<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Discount */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Скидки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discount-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Уверены, что хотите удалить скидку?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            ['attribute'=>'created_at', 'format'=>['datetime', 'dd.MM.Y H:i:s']],
            ['attribute'=>'updated_at', 'format'=>['datetime', 'dd.MM.Y H:i:s']],
            'discount',
            'birthdate_before:boolean',
            'birthdate_after:boolean',
            'phone_exists:boolean',
            'phone_tail',
            ['attribute'=>'gender','value'=>$model->getGender()],
            ['attribute'=>'services', 
            'value'=>implode('<br />', ArrayHelper::getColumn($model->services,'name')),
            'format'=>'html'
            ],
            ['attribute'=>'date_start', 'format'=>['datetime', 'dd.MM.Y']],
            ['attribute'=>'date_end', 'format'=>['datetime', 'dd.MM.Y']],
        ],
    ]) ?>

</div>
