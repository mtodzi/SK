<?php
use yii\helpers\Html;
use yii\helpers\Url;
use budyaga\cropper\Widget;
use yii\widgets\ActiveForm;
//echo $model->id;

$this->title = Yii::t('app', ' Фото {modelClass} - ', [
    'modelClass' => '',
]) . $model->employeename;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Работники'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->employeename, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Фото');


?>
<h1><?= Html::encode($this->title) ?>   <?=$modelUser->employeename?></h1>

 <div class='col-md-12 col-sm-12 col-xs-12'>
    <div class='x_panel'>
        <div class='x_title'>
            <h2>Форма загрузки фотографии работника</h2>
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
            <?php $form = ActiveForm::begin(['id' => 'form']); ?>
            <?php echo $form->field($model, 'id')->widget(Widget::className(), [
                'uploadUrl' => Url::toRoute('/user/user/uploadPhoto'),
                'urlimage' =>  '/advanced/backend/web/fuser/user/'.$model->id,
                'path'=>'@backend/web/fuser/user/'.$model->id
            ])->label(false) ?>
            <?= Html::hiddenInput('id_model', $model->id,['class' => 'id-input'])?>
            <?php ActiveForm::end(); ?>
        </div>
        <div class='clearfix'></div>
        <?= Html::beginForm(['/user/user/filedeletegeneral'], 'post', ['enctype' => 'multipart/form-data','style'=>'float:left;margin:5px;']) ?>
        <?= Html::hiddenInput('id', $model->id);?>
        <?= Html::submitButton('Удалить миниатюру ',['class'=>'btn btn-danger'])?>
        <?= Html::endForm();?> 
    </div>
</div>    
                
                