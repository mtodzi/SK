<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\Acsess */

$this->title = Yii::t('app', 'Обновить {modelClass}: ', [
    'modelClass' => 'доступ',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Роли доступа'), 'url' => ['/acsess']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Выбрать группу действий'), 'url' => ['/acsess/acsess', 'id' => $id_role]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Обновить');
?>
<div class="acsess-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class='col-md-12 col-sm-12 col-xs-12'>
    <div class='x_panel'>
        <div class='x_title'>
            <h2>Доступ к действиям выбранной группы</h2>
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
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'id',
                    'item_name',
                    'idActionCt.alias_action',
                    //'rows',
                    [
                        'attribute'=>'rows',
                        'label'=>'Доступ',
                        'format'=>'text', // Возможные варианты: raw, html
                        'content'=>function($data){
                            return $data->getRowsLabel();
                        },
                        'filter' => array("0"=>"Запрещено","1"=>"Разрешено"),
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                    'template' => '{allow} {deny}',
                    'buttons' => [



                        'allow' => function ($url,$searchModel,$key) {
                            return Html::a(
                            '<span class="glyphicon glyphicon-ok">Разрешить</span>', 
                            $url,['title'=>'Разрешить']);
                        },
                        'deny' => function ($url,$searchModel,$key) {
                            return Html::a(
                            '<span class="glyphicon glyphicon-remove"></span>', 
                            $url,['title'=>'Запретить']);
                        },

                    ]],
                ],
                ]); ?>
            <?php Pjax::end(); ?>
            </div>
        <div class='clearfix'></div>
    </div>
</div>   
</div>
