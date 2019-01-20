<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\acsess\models\SearchAuthItem */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerCssFile('@web/facsess/css/acsess.css');
$this->title = Yii::t('app', 'Роли доступа');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class='col-md-12 col-sm-12 col-xs-12'>
    <div class='x_panel'>
        <div class='x_title'>
            <h2>Все роли доступа</h2>
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
            <strong>Выберите роль для задания прав доступа к действиям в админ панели.</strong>
             </br>
             <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => function ($model, $key, $index, $widget) {
            $bloc = 
            "<div class='col-md-4 col-sm-4 col-xs-12 profile_details'>"
                ."<div class='well profile_view'>"
                    ."<div class='col-sm-12'>"
                        ."<h4 class='brief'><i>".Html::encode($model->name)."</i></h4>"
                        ."<div class='left '>"
                            ."<ul class='list-unstyled'>"
                                ."<li><i class='fa fa-users'></i> <strong>Описание роли: </strong><br>".Html::encode($model->description)."</li>"
                            ."</ul>"
                        ."</div>"                            
                    ."</div>"
                    ."<div class='col-xs-12 bottom text-center'>"                            
                        ."<div class='col-xs-12 col-sm-6 emphasis'>"
                            ."<div class='' style = 'float: left; margin-left: 5px;'>"
                                ."<a href='".Url::to(['view', 'id' => $model->name])."' class='btn btn-primary btn-xs'>"
                                    ."<i class='glyphicon glyphicon-eye-open'> </i> Просмотр"
                                ."</a>"
                            ."</div>"
                            ."<div class='' style = 'float: left; margin-left: 5px;'>"
                                ."<a href='".Url::to(['update', 'id' => $model->name])."' class='btn btn-primary btn-xs'>"
                                    ."<i class='glyphicon glyphicon-pencil'> </i> Редактировать"
                                ."</a>"
                            ."</div>"
                            ."<div class='' style = 'float: left; margin-left: 5px;'>"
                                ."<a href='".Url::to(['/acsess/acsess', 'id' => $model->name])."' class='btn btn-primary btn-xs'>"
                                    ."<i class='glyphicon glyphicon-ok-circle'> </i> Доступ"
                                ."</a>"
                            ."</div>"
                            ."<div class='' style = 'float: left; margin-left: 5px;'>"
                                ."<a href='".Url::to(['delete', 'id' => $model->name])."' class='btn btn-danger btn-xs' data-confirm='Вы хотите удалить выбранную роль - ".$model->name."?' data-method='post'>"
                                    ."<i class='glyphicon glyphicon-trash'> </i> Удалить"
                                ."</a>"
                            ."</div>"
                        ."</div>"
                    ."</div>"
                ."</div>"    
            ."</div>";
    
                return $bloc; //Html::a(Html::encode($model->name), ['view', 'id' => $model->name]);
                },
            ]) ?>
            
<?php
            ?>        
    </div>
        <div class='clearfix'></div>
        <?= Html::a(Yii::t('app', 'Добавить Роль'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
</div>         
</div>

