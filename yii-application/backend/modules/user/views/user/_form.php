<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\user\models\Position;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    
    <div class='col-md-12 col-sm-12 col-xs-12'>
    <div class='x_panel'>
        <div class='x_title'>
            <h2>Форма создания работника</h2>
            <ul class='nav navbar-right panel_toolbox'>
                <li>
                    <a class='collapse-link'><i class='fa fa-chevron-up'></i></a>
                </li>
                <li>
                    <a class='close-link'><i class='fa fa-close'></i></a>
                </li>
            </ul>
            <div class='clearfix'></div>
        </div>
        <div class='x_content'>
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'employeename') ?>
            <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999-999-99-99',]) ?>
            <?= $form->field($model, 'address') ?>
            <?php
            
                $position = Position::find()->all(); 
                $items = ArrayHelper::map($position,'id','name_position');
                $params = [
                    'prompt' => 'Выберите должность'
                ];
                echo $form->field($model, 'id_position')->dropDownList($items,$params);
            ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'prePassword')->passwordInput() ?>
        </div>
        <div class='clearfix'></div>
        <?= Html::submitButton('Добавить работника', ['class' => 'btn btn-success', 'name' => 'signup-button']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
    
</div>