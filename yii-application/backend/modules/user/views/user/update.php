<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', ' Редактировать {modelClass}: ', [
    'modelClass' => '',
]) . $model->employeename;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Работники'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->employeename, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редактировать');
?>
<div class="user-update">

    <?= $this->render('_formupdate', [
        'model' => $model,
    ]) ?>

</div>
