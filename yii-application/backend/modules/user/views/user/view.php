<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\User */
Yii::$app->formatter->locale = 'ru-RU';
$arrRole = \Yii::$app->authManager->getRolesByUser($model->id);
$arRoleUser = array_keys($arrRole);
$this->title = $model->employeename;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Работники'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-view">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class='col-md-12 col-sm-12 col-xs-12'>
    <div class='x_panel'>
        <div class='x_title'>
            <h2>Данные работника</h2>
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
            <div class='col-md-4 col-sm-4 col-xs-12 profile_details'>
                <div class='well profile_view'>
                    <div class='col-sm-12'>
                        <h4 class='brief'><i>Фото сотрудника</i></h4>
                        <div class='right col-xs-5 text-center'>
                            <img src='<?=$model->getUrlMiniature()?>' alt='' class='img-circle img-responsive'>
                            </div>
                          </div>
                          <div class='col-xs-12 bottom text-center'>
                           
                            <div class='col-xs-12 col-sm-6 emphasis'>
                                <a href='<?=Url::to(['foto', 'id' => $model->id])?>'  class='btn btn-primary btn-xs'>
                                <i class='fa fa-file-image-o'> </i> Добавить фото
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
            <div class='clearfix'></div>
            <p>
                У работника заданы такие роли:
                <strong><?php
                if(count($arRoleUser)!=0){
                    for($i=0;count($arRoleUser)>$i;$i++){
                        echo $arRoleUser[$i]."&nbsp;";
                    }
                }else{
                    echo "не заданы";
                }    
                ?></strong>
            </p>
            
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'email:email',
                    'employeename',
                    'phone',
                    'address',
                    [
                      'attribute' => 'position.name_position',
                      'label'=>'Должность'
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' =>  ['date', 'dd.MM.Y'],
                        'options' => ['width' => '200']
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' =>  ['date', 'dd.MM.Y'],
                        'options' => ['width' => '200']
                    ],
                ],
            ]) ?> 
        </div>
        <div class='clearfix'></div>
        <?= Html::a(Yii::t('app', 'Редактировать'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Изменить пароль'), ['changepassword', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Задать роль'), ['asktheemployeerole', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Удалить роль'), ['deletingauserrole', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
            <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                'confirm' => Yii::t('app', 'Вы хотите удалить работника - '.$model->employeename),
                'method' => 'post',
                ],
            ]) ?>
    </div>
    </div>    

</div>
