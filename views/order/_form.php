<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\Service;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('@web/js/order.js', ['depends' => 'yii\web\JqueryAsset']);
?>

<!-- Modal -->
<div class="modal fade" id="modDiscount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Ваша скидка</h4>
      </div>
      <div class="modal-body" style="height: auto;">
          <div class="x-discount"></div>
      </div>
      <div class="modal-footer">
        <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
        <button id="b-discount-ok" type="button" class="btn btn-primary" data-url=''>Закрыть</button>
      </div>
    </div>
  </div>
</div>

<div class="order-form">

    <?php $form = ActiveForm::begin([
        //'id'=>($model->isNewRecord ? 'create-form' : 'update-form'),
        'id'=>'order-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,        
    ]); ?>

    <?php if(!$model->isNewRecord){ ?>
    <div class="form-group field-discount">
        <label class="control-label">Скидка по заказу <?= $model->discount?> %</label>   
    </div>    
    <?php } ?>
    
    <?= $form->field($model, 'customer')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'services')->checkboxList(ArrayHelper::map(Service::find()->all(),'id','name'),['separator' => '<br>']) ?>
    
    <?php if($model->birthdate) $model->birthdate = \Yii::$app->formatter->asDate($model->birthdate, 'dd.MM.Y'); ?>
    <?= $form->field($model, 'birthdate')->widget(DatePicker::classname(), [
        'type' => 3,
        'removeButton'=>false,
        'options' => [],
        'pluginOptions' => ['format' => 'dd.mm.yyyy','todayHighlight' => true,'autoclose'=>true]
        ]) ?>     
    
    <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
        'mask' => '+79999999999',
    ]) ?>  

    <?php if(!$model->gender) $model->gender='male'; ?>
    <?= $form->field($model, 'gender')->radioList($model::getGenders(), ['separator'=>'&nbsp;&nbsp;&nbsp;']); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
