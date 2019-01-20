<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\user\models\SearchControler */
/* @var $dataProvider yii\data\ActiveDataProvider */
//$this->registerCssFile('@web/fdeveloper/css/acsess.css');
$this->title = Yii::t('app', 'Контролеры');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="controler-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a(Yii::t('app', 'Добавить контролер'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Вернуться'), ['/developer'], ['class' => 'btn btn-success']) ?>
    </p>
    <ul class="nav nav-pills nav-stacked">
          <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => function ($model, $key, $index, $widget) {
                $bloc = "<div class = 'blok'>"
                            ."<div class='menu_blok'>" 
                                     ."<a href='".Url::to(['view', 'id' => $model->name_controler])."'>
                                         <img src='".Url::to(['/fdeveloper/imeges/defult.png'])."' alt='".$model->name_controler."' style='width: 230px; height: 230px;'>

                                     </a>"
                            ."</div>"
                            . "<div class='name_menu'>"
                                  ."<span>".Html::encode($model->name_controler)."</span>"
                                  . "<a href='".Url::to(['view', 'id' => $model->id])."'>"
                                        . "<span class = 'glyphicon glyphicon-eye-open'> Просмотр</span>"
                                  . "</a>"
                                  . "<a href='".Url::to(['update', 'id' => $model->id])."'>"
                                        . "<span class = 'glyphicon glyphicon-pencil'> Редактировать</span>"
                                  . "</a>"
                                  . "<a href='".Url::to(['/developer/actionct', 'id' => $model->id])."'>"
                                        . "<span class = 'glyphicon glyphicon-plus'> Действия</span>"
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
    </ul>
</div>
