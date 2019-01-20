<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yiister\gentelella\widgets\grid\GridView;

$this->registerJsFile('@web/fuser/js/posts.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->title = Yii::t('app', 'Чат с '.$userToWhom->employeename);

$this->params['breadcrumbs'][] = ['label' => 'Контакты', 'url' => ['index', 'id'=>1]];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>Тут должен быть чат</h1>
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
        <div>
            <ul class="list-unstyled msg_list" id="ulpost">
            <?php
            echo "<span id = 'count'>";
                echo $count;
            echo "</span>";    
            
            foreach ($models as $model) {
                //echo $model->body_post." - ".date('d-m-Y H:i:s',$model->created_at);
                $bloc = "<li>"
                    ."<a href=".">"
                        ."<span class='image'>"
                            ."<img src='".$model->userFromWhom->getUrlMiniature()."' alt='img'>"
                        ."</span>"
                        ."<span>"
                            ."<span>".$model->userFromWhom->employeename."</span>"
                            ."<span class='time' style='right:85px;' >".date('d-m-Y H:i:s',$model->created_at)."</span>"
                        ."</span>"
                        ."<span class='message_post'>"
                            .$model->body_post
                        ."</span>"
                    ."</a>"
                ."</li>";
                echo $bloc;
               
            }

            /*
            echo ListView::widget(['dataProvider' => $dataPostsProvider, 
                        'itemOptions' => ['class' => 'item'],
                        'layout' => "{summary}\n{pager}\n{items}",            
                        'itemView' => function ($model, $key, $index, $widget) {
                                //$namberProduct = $model->getPriceProduct();
                                $bloc = "<li>"
                                            ."<a href=".">"
                                                ."<span class='image'>"
                                                    ."<img src='".$model->userFromWhom->getUrlMiniature()."' alt='img'>"
                                                ."</span>"
                                                ."<span>"
                                                    ."<span>".$model->userFromWhom->employeename."</span>"
                                                    ."<span class='time' style='right:85px;' >".date('d-m-Y H:i:s',$model->created_at)."</span>"
                                                ."</span>"
                                                ."<span class='message_post'>"
                                                    .$model->body_post
                                                ."</span>"
                                            ."</a>"
                                        ."</li>";
                                            
                                return $bloc;
                        },    ]);

            */
            ?>
             
            </ul>    
        </div>
        <div class='clearfix'></div>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($posts, 'id_user_to_whom')->hiddenInput(['value'=>$userToWhom->id])->label(false) ?>
        <?= $form->field($posts, 'id_user_from_whom')->hiddenInput(['value'=>$userWho->id])->label(false) ?>
        <?= $form->field($posts, 'read_mark')->hiddenInput(['value'=>0])->label(false) ?>
        <?= $form->field($posts, 'body_post')->textarea()->label(false) ?>        
        <?= Html::submitButton(Yii::t('app', 'Отправить') , ['class' =>  'btn btn-success']) ?>
        <?php ActiveForm::end(); ?>
        
<?php
/*
$js = <<<JS
                    $('form').on('beforeSubmit', function(){
                        alert('Работает!');
                        return false;
                    });
JS;
$this->registerJs($js);
 * 
 */
?>
        
    </div>
</div>
<div class='clearfix'></div>