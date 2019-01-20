<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\ActionCt */

$this->title = $model->action_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Контролеры'), 'url' => ['/developer/controler']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $model->idControler->name_controler), 'url' => ['index','id'=>$model->id_controler]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="action-ct-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Редактировать'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Вы уверены, что хотите удалить этот элемент?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'action_name',
            'alias_action',
            'description:ntext',
            'idControler.name_controler',
        ],
    ]) ?>

</div>
