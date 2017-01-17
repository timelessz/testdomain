<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php if ($model->isNewRecord): ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => 32]) ?>
    <?php else: ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => 32, 'readonly' => '']) ?>
    <?php endif; ?>
    <?= $form->field($model, 'password')->passwordInput(['minlength' => 6, 'maxlength' => 20]) ?>
    <?= $form->field($model, 'screenName')->textInput(['maxlength' => 32]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '增加用户' : '编辑用户', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
