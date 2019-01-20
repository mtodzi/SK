<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\Controler */

$this->title = Yii::t('app', 'Добавить контролер');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Контролеры'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="controler-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
