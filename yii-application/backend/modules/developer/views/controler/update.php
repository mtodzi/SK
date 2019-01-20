<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\Controler */

$this->title = Yii::t('app', 'Редактировать {modelClass}: ', [
    'modelClass' => 'контролер',
]) . $model->name_controler;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Контролеры'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name_controler, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редактировать');
?>
<div class="controler-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
