<?php

use yii\helpers\Html;
use backend\modules\acsess\models\Acsess;
use backend\modules\developer\models\ActionCt;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\Acsess */

$this->title = Yii::t('app', 'Создать Правила');

?>
<div class="acsess-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
        $actionct = ActionCt::find()
                                ->select('id')
                                ->where(['id_controler'=>$id])
                                ->asArray()
                                ->all();
        print_r ($actionct);
        $var = array();
        foreach ($actionct as $data){
           $var[] = $data[id];
        }
        print_r($var);
        
        $query = Acsess::find()->where(['id'=>$var])->asArray()
                                ->all();
        print_r($query);
        echo $id_role;
        echo "<br>";
        echo $id;
        echo "<br>";
        //echo $j;
       
    ?>

</div>
