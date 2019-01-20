<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\user\models\SearchAcsess */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->registerCssFile('@web/facsess/css/acsess.css');
$this->title = Yii::t('app', 'Выбрать группу действий для назначения доступа для роли '.$id);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Роли доступа'), 'url' => ['auth/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="acsess-index">
    <h1><?= Html::encode($this->title) ?></h1> 
    <div class='col-md-12 col-sm-12 col-xs-12'>
    <div class='x_panel'>
        <div class='x_title'>
            <h2>Все группы действий</h2>
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
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'col-md-4 col-sm-4 col-xs-12 profile_details'],
                'itemView' => function ($model, $key, $index, $widget) {
                    $arrRole = \Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id);
                    $arRoleUser = array_keys($arrRole);
                    $dostup = 0;
                    for($i=0;count($arRoleUser)>$i;$i++){
                        if(!strcmp($arRoleUser[$i],'admin')){
                            $dostup = 1; 
                        }                       
                    }
                    
                    $bloc = 
                        "<div class='well profile_view'>"
                            ."<div class='col-sm-12'>"
                                ."<h4 class='brief'><i>".Html::encode($model->name_controler)."</i></h4>"
                                ."<div class='left'>"
                                    ."<ul class='list-unstyled'>"
                                        ."<li><i class='fa fa-cogs'></i> <strong>Описание контроллера - группы: </strong><br>".Html::encode($model->description)."</li>"
                                    ."</ul>"
                                ."</div>"                            
                            ."</div>"
                            ."<div class='col-xs-12 bottom text-center'>"                            
                                ."<div class='col-xs-12 col-sm-6 emphasis'>"
                                    ."<div class='' style = 'float: left; margin-left: 5px;'>"
                                        ."<a href='".Url::to(['create', 'id' => $model->id])."' class='btn btn-primary btn-xs'>"
                                            ."<i class='glyphicon glyphicon-plus'> </i> Назначить"
                                        ."</a>"
                                    ."</div>"
                                ."</div>"
                            ."</div>"
                        ."</div>";
                if($dostup == 1){
                    return $bloc;
                }else{
                    if($model->id <=3){
                        return false;
                    }else{
                        return $bloc;
                    }
                }
                },
            ]) ?>
        </div>
        <div class='clearfix'></div>
    </div>
</div>   
</div>
