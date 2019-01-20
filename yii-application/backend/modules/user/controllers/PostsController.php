<?php
namespace app\modules\user\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\user\models\UserSearch;
use backend\modules\user\models\Posts;
use common\models\User;


class PostsController extends Controller
{

    public function actionIndex()            
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->searchUserContacts(Yii::$app->request->queryParams,Yii::$app->user->identity->id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($id){
        $userWho = User::findOne(Yii::$app->user->identity->id);
        $userToWhom = User::findOne($id);
        //$serhPosts = new \backend\modules\user\models\SearchPosts;
        //$dataPostsProvider = $serhPosts->searchPosts($params, $userToWhom, $userWho); 
        $query = Posts::find()->where(['or',['or','id_user_to_whom='.$userToWhom->id,'id_user_to_whom='.$userWho->id],
                                      ['or','id_user_from_whom='.$userWho->id,'id_user_from_whom='.$userToWhom->id]]);
        $count = $query->count();
        $models = $query->limit(5)->offset($count-5)->all();
        $posts = new Posts;
        
        return $this->render('view',['models'=>$models,
                                    'userWho'=>$userWho,
                                    'userToWhom'=>$userToWhom,
                                    'posts'=>$posts,
                                    //'serhPosts'=>$serhPosts,
                                    'count'=>$count,
                                    /*'dataPostsProvider'=>$dataPostsProvider*/]);
    }
    
    public function actionCreateposts(){
        $model = new Posts();        
        if(\Yii::$app->request->isAjax){
            if ($model->load(Yii::$app->request->post()) && $model->save()){
                $text = $model->id_user_from_whom."--".$model->id_user_to_whom."--".$model->body_post;
                return "Данные загруженны в модель ".$text;
            }else{
                return 'Данные не загруженны в модель и не сахранены';
            }
        }else{
            return "Запрос не верен";
        }
    }   
     public function actionGetnewposts(){
        $model = new Posts();        
        if(\Yii::$app->request->isAjax){
            $id = Yii::$app->request->post('id_user_to_whom');
            $count = Yii::$app->request->post('count');
            $userWho = User::findOne(Yii::$app->user->identity->id);
            $userToWhom = User::findOne($id);
            $query = Posts::find()->where(['or',['or','id_user_to_whom='.$userToWhom->id,'id_user_to_whom='.$userWho->id],
                                      ['or','id_user_from_whom='.$userWho->id,'id_user_from_whom='.$userToWhom->id]]);
            $count_qvery = $query->count();
            $models = $query->limit($count_qvery-$count)->offset($count_qvery-($count_qvery-$count))->all();
            $posts = new Posts;
            return $this->renderAjax('viewajax',['models'=>$models,
                                    'userWho'=>$userWho,
                                    'userToWhom'=>$userToWhom,
                                    'posts'=>$posts,
                                    'count_qvery'=>$count_qvery]);
        }else{
            return "Запрос не верен";
        }
    }
    
}

