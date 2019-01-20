<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('app', ' Редактировать пароль: ', [
    'modelClass' => 'User',
]) . $model->employeename;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Работники'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->employeename, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редактировать пароль');
$modelUser->id = $model->id;
?>

<div class="user-form">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class='col-md-12 col-sm-12 col-xs-12'>
    <div class='x_panel'>
        <div class='x_title'>
            <h2>Измените пароль</h2>
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
            <?= $form->field($modelUser, 'password')->passwordInput() ?>
            <?= $form->field($modelUser, 'prePassword')->passwordInput() ?>
            <?=$form->field($modelUser, 'id')->hiddenInput()->label(false, ['style'=>'display:none'])?>         
        </div>
        <div class='clearfix'></div>
        <?= Html::submitButton('Изменить пароль', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        <?php ActiveForm::end(); ?>
    </div>
    </div>    
</div>
