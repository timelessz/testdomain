<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => 100]) ?>
    <?= $form->field($model, 'mail')->textInput() ?>
    <?= $form->field($model, 'detail')->textInput(['maxlength' => 32]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '增加检测网址' : '修改检测网址', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div> 
