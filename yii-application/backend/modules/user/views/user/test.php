<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Url;
use yiister\gentelella\widgets\Accordion;
use yiister\gentelella\widgets\Panel;
use backend\assets\AssetKartikFileInput;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//$this->registerCssFile('@web/fuser/css/user.css');
AssetKartikFileInput::register($this);
$this->title = Yii::t('app', 'Персонал');

?>



<div class='index_user_bloc row'>
    
    <div class="my_heders_bloc col-xl-9 col-lg-9 col-md-11 col-sm-11 col-8">
        <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="<?=Url::to(['/user/user'])?>">Персонал</a>
            
            <!--кнопка добавить сотрудника-->
            <a  class="nav-link btn btn-dark mx-1 mr-auto" href="#" data-toggle="tooltip" data-placement="right" title="Добавить">
                <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/add.svg'])?>' alt="Добавить">
            </a>
            
            <form class="form-inline">
                <input class="form-control mr-2 my-2" type="search" placeholder="Поиск" aria-label="Search">
                <button class="btn btn-outline-success my-2" type="submit">Поиск</button>
            </form>
        </nav>
    </div>
    <div class="my_content_bloc col-10">
        <div class="row">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12  my-1">
                <input id="input-id" type="file">
                <div class="my_box">
                    <div class = "my_box_heder">
                        <nav class="navbar navbar-light bg-dark rounded-top">
                            <span class="navbar-brand text-light">Карточка сотрудника</span>
                                
                                <!--группировка кнопок в navbar с выравниванием вправо-->
                                <div class="btn-group ml-auto"> 
                                
                                <!--кнопка добавить в архив сотрудника-->
                                    <a  class="nav-link btn btn-light mx-1" href="<?=Url::to(['/user/user'])?>" data-toggle="tooltip" data-placement="left" title="В архив">
                                        <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/addarch.svg'])?>' alt="В архив">
                                    </a>
                                
                                <!--кнопка редактировать сотрудника-->
                                    <a  class="nav-link btn btn-light" href="<?=Url::to(['/user/user'])?>" data-toggle="tooltip" data-placement="right" title="Редактировать">
                                        <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/edit.svg'])?>' alt="Редактировать">
                                    </a>
                                
                                </div>                        
                        </nav>
                    </div>             
                    <div class="my_box_content rounded-bottom bg-light border border-top-0 border-dark">
                        <div class="row py-2">
                            <div class="col-10 col-xl-2 col-md-2">
                                <img class="user_photo bg-secondary mx-2" src="<?=Url::to(['/img/6170248_xlarge.jpg'])?>" class="align-self-start mr-3" alt="...">
                            </div>
                            <div class="px-4 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">
                                <h5 class="mt-0">Батасов Роман Александрович - инженер</h5>
                                <p class="p_margin0"><img class="my_icon" src="<?=Url::to(['/img/mail.svg'])?>">romanbatasov @gmail.com</p>
                                <p class="p_margin0"><img class="my_icon" src="<?=Url::to(['/img/smartphone-call.svg'])?>">(050) 789-98-65</p>
                                <p class="p_margin0"><img class="my_icon" src="<?=Url::to(['/img/home.svg'])?>">ул. Щетинина д. 12 кв. 113 </p>
                                <p></p>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12  my-1">
                <div class="my_box">
                    <div class = "my_box_heder">
                        <nav class="navbar navbar-light bg-dark rounded-top">
                            <span class="navbar-brand text-light">Карточка сотрудника</span>
                            
                            <!--группировка кнопок в navbar с выравниванием вправо-->
                                <div class="btn-group ml-auto"> 
                                <!--кнопка отменить изменения и вернуться-->
                                    <a  class="nav-link btn btn-light mx-1" href="<?=Url::to(['/user/user'])?>" data-toggle="tooltip" data-placement="left" title="Отмена">
                                        <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/abort.svg'])?>' alt="Отмена">
                                    </a>
                                <!--кнопка применить изменения-->
                                    <a  class="nav-link btn btn-light" href="<?=Url::to(['/user/user'])?>" data-toggle="tooltip" data-placement="right" title="Применить">
                                        <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/accept.svg'])?>' alt="Применить">
                                    </a>
                                </div>
                        
                        </nav>
                    </div>             
                    <div class="my_box_content rounded-bottom bg-light border border-top-0 border-dark">
                        <div class="row py-2">
                            <div class="col-10 col-xl-2 col-md-2">
                                <img class="user_photo bg-secondary mx-2" src="<?=Url::to(['/img/6170248_xlarge.jpg'])?>" class="align-self-start mr-3" alt="...">
                            </div>
                                <div class="px-4 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">
                                    <h5><p class="form-row my-2 mx-2"> <input class="form-control col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12" type="text" placeholder="Батасов Роман Александрович"> - 
                                        <select class="form-control col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"> 
                                            <option>инженер</option>
                                            <option>менеджер</option>
                                            <option>директор</option>
                                        </select> 
                                    </p>
                                    </h5>
                                    <p class="form-row my-2"><img class="my_icon mx-1 my-2" src="<?=Url::to(['/img/mail.svg'])?>"> <input class="form-control col-10" type="mail" placeholder="romanbatasov @gmail.com"> </p>
                                    <p class="form-row my-2"><img class="my_icon mx-1 my-2" src="<?=Url::to(['/img/smartphone-call.svg'])?>"> <input class="form-control col-10" type="text" placeholder="(050) 789-98-65"> </p>
                                    <p class="form-row my-2"><img class="my_icon mx-1 my-2" src="<?=Url::to(['/img/home.svg'])?>"> <input class="form-control col-10" type="text" placeholder="ул. Щетинина д. 12 кв. 13"> </p>
                                </div>
                        
                        </div>    
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12  my-1">
                <div class="my_box">
                    <div class = "my_box_heder">
                        <nav class="navbar navbar-light bg-dark rounded-top">
                            <span class="navbar-brand text-light">Карточка сотрудника</span>
                            
                            <!--группировка кнопок в navbar с выравниванием вправо-->
                                <div class="btn-group ml-auto"> 
                                <!--кнопка отменить изменения и вернуться-->
                                    <a  class="nav-link btn btn-light mx-1" href="<?=Url::to(['/user/user'])?>" data-toggle="tooltip" data-placement="left" title="Отмена">
                                        <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/abort.svg'])?>' alt="Отмена">
                                    </a>
                                <!--кнопка применить изменения-->
                                    <a  class="nav-link btn btn-light" href="<?=Url::to(['/user/user'])?>" data-toggle="tooltip" data-placement="right" title="Применить">
                                        <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/accept.svg'])?>' alt="Применить">
                                    </a>
                                </div>
                        
                        </nav>
                    </div>             
                    <div class="my_box_content rounded-bottom bg-light border border-top-0 border-dark">
                        <div class="row py-2">
                            <div class="col-10 col-xl-2 col-md-2">
                                <img class="user_photo bg-secondary mx-2" src="<?=Url::to(['/img/6170248_xlarge.jpg'])?>" class="align-self-start mr-3" alt="...">
                            </div>
                                <div class="px-4 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">
                                    <h5><p class="form-row my-2 mx-2"> <input class="form-control col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12" type="text" placeholder="Батасов Роман Александрович"> - 
                                        <select class="form-control col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"> 
                                            <option>инженер</option>
                                            <option>менеджер</option>
                                            <option>директор</option>
                                        </select> 
                                    </p>
                                    </h5>
                                    <p class="form-row my-2"><img class="my_icon mx-1 my-2" src="<?=Url::to(['/img/mail.svg'])?>"> <input class="form-control col-10" type="mail" placeholder="romanbatasov @gmail.com"> </p>
                                    <p class="form-row my-2"><img class="my_icon mx-1 my-2" src="<?=Url::to(['/img/smartphone-call.svg'])?>"> <input class="form-control col-10" type="text" placeholder="(050) 789-98-65"> </p>
                                    <p class="form-row my-2"><img class="my_icon mx-1 my-2" src="<?=Url::to(['/img/home.svg'])?>"> <input class="form-control col-10" type="text" placeholder="ул. Щетинина д. 12 кв. 13"> </p>
                                </div>
                        
                        </div>    
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12  my-1">
                <div class="my_box">
                    <div class = "my_box_heder">
                        <nav class="navbar navbar-light bg-dark rounded-top">
                            <span class="navbar-brand text-light">Карточка сотрудника</span>
                            
                            <!--группировка кнопок в navbar с выравниванием вправо-->
                                <div class="btn-group ml-auto"> 
                                <!--кнопка отменить изменения и вернуться-->
                                    <a  class="nav-link btn btn-light mx-1" href="<?=Url::to(['/user/user'])?>" data-toggle="tooltip" data-placement="left" title="Отмена">
                                        <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/abort.svg'])?>' alt="Отмена">
                                    </a>
                                <!--кнопка применить изменения-->
                                    <a  class="nav-link btn btn-light" href="<?=Url::to(['/user/user'])?>" data-toggle="tooltip" data-placement="right" title="Применить">
                                        <img id ="menu_navbar_top" class="" src='<?=Url::to(['/img/accept.svg'])?>' alt="Применить">
                                    </a>
                                </div>
                        
                        </nav>
                    </div>             
                    <div class="my_box_content rounded-bottom bg-light border border-top-0 border-dark">
                        <div class="row py-2">
                            <div class="col-10 col-xl-2 col-md-2">
                                <img class="user_photo bg-secondary mx-2" src="<?=Url::to(['/img/6170248_xlarge.jpg'])?>" class="align-self-start mr-3" alt="...">
                            </div>
                                <div class="px-4 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">
                                    <h5><p class="form-row my-2 mx-2"> <input class="form-control col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12" type="text" placeholder="Батасов Роман Александрович"> - 
                                        <select class="form-control col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"> 
                                            <option>инженер</option>
                                            <option>менеджер</option>
                                            <option>директор</option>
                                        </select> 
                                    </p>
                                    </h5>
                                    <p class="form-row my-2"><img class="my_icon mx-1 my-2" src="<?=Url::to(['/img/mail.svg'])?>"> <input class="form-control col-10" type="mail" placeholder="romanbatasov @gmail.com"> </p>
                                    <p class="form-row my-2"><img class="my_icon mx-1 my-2" src="<?=Url::to(['/img/smartphone-call.svg'])?>"> <input class="form-control col-10" type="text" placeholder="(050) 789-98-65"> </p>
                                    <p class="form-row my-2"><img class="my_icon mx-1 my-2" src="<?=Url::to(['/img/home.svg'])?>"> <input class="form-control col-10" type="text" placeholder="ул. Щетинина д. 12 кв. 13"> </p>
                                </div>
                        
                        </div>    
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
</div>
