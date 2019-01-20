<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yiister\gentelella\widgets\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\user\models\SearchPosition */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Должности';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>
    </br>

<div class='col-md-12 col-sm-12 col-xs-12'>
    <div class='x_panel'>
        <div class='x_title'>
            <h2>Все должности</h2>
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
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'filterRowOptions' => [],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'id',
                        'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Поиск по ключу...'
                        ]
                    ],
                    
                    [
                        'attribute' => 'name_position',
                        'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Поиск по названию...'
                        ]
                    ],
                    [
                        'attribute' => 'description_position',
                        'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Поиск по описанию...'
                        ]
                    ],

                    //['class' => 'yii\grid\ActionColumn'],
                    ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}</br>{update}</br>{delete}',
                    'buttons' => [
                        'view' => function ($url,$dataProvider,$key) {
                            return Html::a(Yii::t('app', 'Просмотр'),                    
                            ['/user/position/view','id'=>$dataProvider->id], ['class' => 'btn btn-info btn-xs']);
                        },
                        'update' => function ($url,$dataProvider,$key) {
                            return Html::a(Yii::t('app', 'Редактировать'),                    
                            ['/user/position/update','id'=>$dataProvider->id], ['class' => 'btn btn-primary btn-xs']);
                        },
                        'delete' => function ($url,$dataProvider,$key) {
                            return Html::a(Yii::t('app', 'Удалить'),                    
                            ['/user/position/delete','id'=>$dataProvider->id], ['class' => 'btn btn-danger btn-xs', 'data' => ['confirm' => 'Вы хотите удалит должность - '.$dataProvider->name_position,'method' => 'post',],]);
                        },
                    ]],
                ],
            ]); ?>
        </div>
        <div class='clearfix'></div>
        <?= Html::a('Добавить должность', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
</div>
</div>    