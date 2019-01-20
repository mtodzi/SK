<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\acsess\models\SearchAuthItem */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerCssFile('@web/fdeveloper/css/acsess.css');
$this->title = Yii::t('app', 'Инструментарий');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="developer-default-index">
    <h1>Инструменты для создания действий.</h1>
<?php    
    $bloc = "<div class = 'blok'>"
                            ."<div class='menu_blok'>" 
                                     ."<a href='".Url::to(['/developer/controler'])."'>
                                         <img src='".Url::to(['/fdeveloper/imeges/defult.png'])."' alt='Инструментарий' style='width: 230px; height: 230px;'>

                                     </a>"
                            ."</div>"
                            . "<div class='name_menu'>"
                                  ."<span>Контролеры</span>"      
                            ."</div>"
                        ."</div>"     
                     ;
    
            echo $bloc;
?>            
</div>
