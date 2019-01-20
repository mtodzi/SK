<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\user\models\SearchActionCt */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerCssFile('@web/fdeveloper/css/acsess.css');
$this->title = Yii::t('app', 'Действия контролера '.$model->name_controler);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Контролеры'), 'url' => ['/developer/controler']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="action-ct-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Добавить действие'), ['create','id'=>$model->id], ['class' => 'btn btn-success']) ?>
    </p>
   <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
           $bloc = "<div class = 'blok'>"
                            ."<div class='menu_blok'>" 
                                     ."<a href='".Url::to(['view', 'id' => $model->id])."'>
                                         <img src='".Url::to(['/fdeveloper/imeges/defult.png'])."' alt='".$model->action_name."' style='width: 230px; height: 230px;'>

                                     </a>"
                            ."</div>"
                            . "<div class='name_menu'>"
                                  ."<span>".Html::encode($model->action_name)."</span>"
                                  . "<a href='".Url::to(['view', 'id' => $model->id])."'>"
                                        . "<span class = 'glyphicon glyphicon-eye-open'> Просмотр</span>"
                                  . "</a>"
                                  . "<a href='".Url::to(['update', 'id' => $model->id])."'>"
                                        . "<span class = 'glyphicon glyphicon-pencil'> Редактировать</span>"
                                  . "</a>"
                                  . "<a href='".Url::to(['delete', 'id' => $model->id])."' data-confirm='Вы уверены, что хотите удалить этот элемент?' data-method='post'>"
                                        . "<span class = 'glyphicon glyphicon-trash'> Удалить</span>"
                                  . "</a>"
                            ."</div>"
                        ."</div>"     
                     ;
    
            return $bloc;
        },
    ]) ?>
</div>
