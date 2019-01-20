<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\ActionCt */
/* @var $form yii\widgets\ActiveForm */

$model->isNewRecord ? $data = $controler->id : $data = $model->id_controler;
?>

<div class="action-ct-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'action_name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'alias_action')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_controler')->hiddenInput(['value'=>$data])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Добавить') : Yii::t('app', 'Редактировать'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
