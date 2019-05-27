<?php
    use yii\widgets\ListView;
   
?>

<div id="index_stock_bloc"  class='index_stock_bloc'>
    <div class='my_content_bloc'>        
        <div id="new_serialnumbers">
            <?=$this->render('serialnumbers', ['model' => null,])?>
        </div>    
<?php
        echo ListView::widget([
                'dataProvider' => $dataProvider,
                'pager' => [
                    'maxButtonCount' => 3,
                    // Customzing options for pager container tag
                    'options' => [
                        'tag' => 'ul',
                        'class'=>'pagination my-2 justify-content-center'   
                    ],
                    // Customzing CSS class for pager link
                    'linkContainerOptions'=>[
                        'class'=>'page-item'
                    ],
                    'linkOptions' => [
                        'class' => 'page-link'
                    ],
                    
                    'activePageCssClass' => 'active',
                    'disabledPageCssClass' => 'disable disabled page-link',
                    
                     
                ],
                'options'=> ['class' => 'wrapper'],
                'itemOptions' => ['class' => ''],
                'summary'=>FALSE,
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('serialnumbers', ['model' => $model,]);
                },
        ]);
     ?>    
        
    </div>
    <div class='my_footer_bloc co-12'>
    </div>
</div>
