<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Контакты');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
<div class='col-md-12 col-sm-12 col-xs-12'>
    <div class='x_panel'>
        <div class='x_title'>
            <h2></h2>
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
            <ul class="list-unstyled msg_list">
            <?= ListView::widget(['dataProvider' => $dataProvider, 
                        'itemOptions' => ['class' => 'item'],
                        'pager' => [
                                'firstPageLabel' => 'Первая',
                                'lastPageLabel' => 'Последняя',
                                'maxButtonCount' => 5,
                        ],            
                        'itemView' => function ($model, $key, $index, $widget) {
                                //$namberProduct = $model->getPriceProduct();
                                $bloc = "<li>"
                                            ."<a href=".Url::to(['/user/posts/view','id'=>$model->id]).">"
                                                ."<span class='image'>"
                                                    ."<img src='".$model->getUrlMiniature()."' alt='img'>"
                                                ."</span>"
                                                ."<span>"
                                                    ."<span>".$model->employeename."</span>"
                                                    ."<span class='time'>3 mins ago</span>"
                                                ."</span>"
                                                ."<span class='message'>"
                                                    ."Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that"
                                                ."</span>"
                                            ."</a>"
                                        ."</li>";
                                            
                                return $bloc;
                        },    ]);

            ?>
            </ul>    
        </div>
        <div class='clearfix'></div>
    </div>
                    
</div>
</div>