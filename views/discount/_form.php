<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Order;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\Service;

/* @var $this yii\web\View */
/* @var $model app\models\Discount */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('@web/js/discount.js', ['depends' => 'yii\web\JqueryAsset']);
?>

<div class="discount-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'discount')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'birthdate_before')->checkbox() ?>

    <?= $form->field($model, 'birthdate_after')->checkbox() ?>

    <?= $form->field($model, 'phone_exists')->checkbox() ?>

    <?= $form->field($model, 'phone_tail')->textInput() ?>

    <?= $form->field($model, 'gender')->dropDownList(Order::getGenders(),['prompt'=>'He выбрано']) ?>

    <?= $form->field($model, 'services')->checkboxList(ArrayHelper::map(Service::find()->all(),'id','name'),['separator' => '<br>']) ?>
    
    <?php if($model->date_start) $model->date_start = \Yii::$app->formatter->asDate($model->date_start, 'dd.MM.Y'); ?>
    <?= $form->field($model, 'date_start')->widget(DatePicker::classname(), [
        'type' => 3,
        'removeButton' => [
            'icon'=>'trash',
        ],
        'options' => [],
        'pluginOptions' => ['format' => 'dd.mm.yyyy','todayHighlight' => true,'autoclose'=>true],
        'pluginEvents' => [
            'changeDate' => 'function(e) { 
                var startDate = new Date(e.date);
                $("#discount-date_end").parent().kvDatepicker("setStartDate", startDate );
            }',
        ],
        ]) ?> 
    
    <?php if($model->date_end) $model->date_end = \Yii::$app->formatter->asDate($model->date_end, 'dd.MM.Y'); ?>
    <?= $form->field($model, 'date_end')->widget(DatePicker::classname(), [
        'type' => 3,
        'removeButton' => [
            'icon'=>'trash',
        ],
        'options' => [],
        'pluginOptions' => ['format' => 'dd.mm.yyyy','todayHighlight' => true,'autoclose'=>true],
        'pluginEvents' => [
            'changeDate' => 'function(e) { 
                var endDate = new Date(e.date);
                $("#discount-date_start").parent().kvDatepicker("setEndDate", endDate );
            }',
        ],        
        ]) ?>     

    <div class="form-group" style="margin-top: 2em;">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
