<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\acsess\models\AuthItem */

$this->title = Yii::t('app', 'Изменить {modelClass}: ', [
    'modelClass' => 'Роль',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Роли доступа'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Изменить Роль');
?>
<div class="auth-item-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class='col-md-12 col-sm-12 col-xs-12'>
    <div class='x_panel'>
        <div class='x_title'>
            <h2>Форма редактирования роли</h2>
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
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 2, 'cols' => 5]) ?>
        </div>
        <div class='clearfix'></div>
        <?= Html::submitButton('Изменить Роль', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        <?= Html::a(Yii::t('app', 'Вернуться'), ['index'], ['class' => 'btn btn-success']) ?>
        <?php ActiveForm::end(); ?>
    </div>
    </div>           
</div>
