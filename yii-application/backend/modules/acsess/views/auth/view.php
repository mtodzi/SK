<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\acsess\models\AuthItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Роли доступа'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class='col-md-12 col-sm-12 col-xs-12'>
    <div class='x_panel'>
        <div class='x_title'>
            <h2>Данные выбранной роли</h2>
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
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                'name',
                //'type',
                'description:ntext',
                //'rule_name',
                //'data:ntext',
                //'created_at',
                //'updated_at',
                ],
            ]) ?>
        
            
        </div>
        <div class='clearfix'></div>
        <?= Html::a(Yii::t('app', 'Редактировать'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Вы хотите удалить выбранную роль - '.$model->name.'?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>
</div>
</div>
