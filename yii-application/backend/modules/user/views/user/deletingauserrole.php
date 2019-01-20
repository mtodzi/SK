<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Удалить роль';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Работники'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$model->id = $modelUser->id;
$array = \Yii::$app->authManager->getRoles();
$arrRole = \Yii::$app->authManager->getRolesByUser($modelUser->id);


$arRoleUser = array_keys($arrRole);
$arrayRole = array_keys($array);

for($i=0; count($arrayRole)>$i; $i++){
   if(!in_array($arrayRole[$i], $arRoleUser)){
       $arrayNotUserRole[] = $arrayRole[$i];
   } 
}
$arra = array_combine (array_values($arRoleUser) , array_values($arRoleUser) );
?>
<div class="delete-role">
    <h1><?= Html::encode($this->title) ?> - <?=$modelUser->employeename?></h1>
    <div class='col-md-12 col-sm-12 col-xs-12'>
    <div class='x_panel'>
        <div class='x_title'>
            <h2>Форма удаления роли у работника</h2>
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
            <p>Выберите роль для удаления</p>
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?php 
                    if(count($arRoleUser)!=0){
                        echo $form->field($model, 'id')->hiddenInput()->label(false, ['style'=>'display:none']);
                        echo $form->field($model, 'role')->dropDownList($arra);
                    }else{
                        echo "У выбранного работника не заданы роли";
                    }
                ?>
                                   
        </div>
        <div class='clearfix'></div>        
            <?php
                if(count($arRoleUser)!=0){
                    echo Html::submitButton('Удалить роль', ['class' => 'btn btn-primary', 'name' => 'signup-button']);
                }
            ?>
            <?php ActiveForm::end(); ?>
         </div>
</div>
</div><!-- /.box-footer -->   