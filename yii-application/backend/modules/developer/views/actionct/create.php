<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\ActionCt */

$this->title = Yii::t('app', 'Добавить действие '.$controler->name_controler);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Контролеры'), 'url' => ['/developer/controler']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $controler->name_controler), 'url' => ['index','id'=>$controler->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="action-ct-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'controler'=>$controler
    ]) ?>

</div>
