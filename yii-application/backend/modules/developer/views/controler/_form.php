<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\Controler */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="controler-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_controler')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'alias_controler')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Добавить') : Yii::t('app', 'Редактировать'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
