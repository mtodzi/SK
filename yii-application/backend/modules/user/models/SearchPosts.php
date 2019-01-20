<?php

namespace backend\modules\user\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\Posts;


class SearchPosts extends Posts
{
    public function rules()
    {
        return [
            
        ];
    }
    
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    public function searchPosts($params,$id_user_to_whom,$id_user_from_whom)
    {
        
        $query_select = Posts::updateAll(['read_mark'=>1],
                                            [ 'and',
                                                'id_user_to_whom='.$id_user_from_whom->id,
                                                'id_user_from_whom='.$id_user_to_whom->id,
                                                'read_mark=0'
                                            ]);
        
        $query = Posts::find()->where(['and',['or','id_user_to_whom='.$id_user_to_whom->id,'id_user_to_whom='.$id_user_from_whom->id],
                                      ['or','id_user_from_whom='.$id_user_to_whom->id,'id_user_from_whom='.$id_user_from_whom->id]]);
                                      //->orderBy(['created_at'=>'DESC']);
        
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
                //'page' => LINK_LAST,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_ASC, 
                ]
            ],
        ]);


        return $dataProvider;
    }
    
}
