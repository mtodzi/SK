<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>
<div class="container">
<?php $form = ActiveForm::begin(['id' => 'login-form','options' => ['class'=>'form-signin align-items-center']]); ?>
    <div class="row">
        <div class="col-lg-1">   
        </div>
        <div class="text-center col-lg-7">
            <img id ="img_992_more" class="mb-4" src='<?=Url::to(['img/loginimg.svg'])?>' alt="Тут должно быть лого">
            <img id ="img_992_less" class="mb-4" src='<?=Url::to(['img/logo_v1.svg'])?>' alt="Тут должно быть лого">
        </div>
        <div class="col-lg-4">   
        </div>
    </div>
    <div class="row my_row_input_login">
        <div class="col-lg-4">   
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'username',['errorOptions' => ['class' => 'text-danger']])->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'password',['errorOptions' => ['class' => 'text-danger']])->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
            <div class="row form-group">
                <div class="text-left col">
                    <?= Html::a('Назад к сайту', ['#'], ['class' => 'text-muted']) ?>
                </div>
                <div class="text-right col">
                    <?= Html::a('Забыли пароль?', ['#'], ['class' => 'text-muted text-md-right']) ?>
                </div>                        
            </div>
            <div class="form-group text-center">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-outline-dark', 'name' => 'login-button']) ?>
            </div>   
        </div>    
        <div class="col-lg-4">    
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
