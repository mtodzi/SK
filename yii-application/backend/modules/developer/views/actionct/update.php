<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\ActionCt */

$this->title = Yii::t('app', 'Редактировать {modelClass}: ', [
    'modelClass' => 'действие',
]) . $model->action_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Контролеры'), 'url' => ['/developer/controler']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $model->idControler->name_controler), 
                                  'url' => ['index','id'=>$model->id_controler]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редактировать');
?>
<div class="action-ct-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
