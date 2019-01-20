<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Задать роль';
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
if(count($arrayNotUserRole)!=0){
    $arra = array_combine (array_values($arrayNotUserRole) , array_values($arrayNotUserRole) );
}else{
    $arra=0;
}    
?>
<div class="site-signup">
<h1 class="box-title"><?= Html::encode($this->title) ?> - <?=$modelUser->employeename?></h1>
<div class='col-md-12 col-sm-12 col-xs-12'>
    <div class='x_panel'>
        <div class='x_title'>
            <h2>Форма присвоения роли работнику</h2>
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
            <?php $form = ActiveForm::begin(['id' => 'form-signup']);
                echo $form->field($model, 'id')->hiddenInput()->label(false, ['style'=>'display:none']);
                if($arra !=0){
                echo $form->field($model, 'role')->dropDownList($arra);
                    echo "</div>";
                    echo "<div class='clearfix'></div>";
                    echo Html::submitButton('Задать роль', ['class' => 'btn btn-primary', 'name' => 'signup-button']);          
                }else{
                    echo "У работника заданы все роли";
                    echo "</div>";
                    echo "<div class='clearfix'></div>";
                }
                ActiveForm::end(); ?>
    </div>
</div>
</div>
</div>