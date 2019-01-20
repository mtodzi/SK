<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\Position */

$this->title = 'Обновить данные должности - '.$model->name_position;
$this->params['breadcrumbs'][] = ['label' => 'Все должности', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name_position, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="position-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
