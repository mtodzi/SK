<?php

namespace backend\modules\acsess\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\acsess\models\Acsess;
use backend\modules\developer\models\ActionCt;
/**
 * SearchAcsess represents the model behind the search form about `backend\modules\user\models\Acsess`.
 */
class SearchAcsess extends Acsess
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_action_ct', 'rows'], 'integer'],
            [['item_name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Acsess::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_action_ct' => $this->id_action_ct,
            'rows' => $this->rows,
        ]);

        $query->andFilterWhere(['like', 'item_name', $this->item_name]);

        return $dataProvider;
    }
     public function searchRoleControle($params,$id_controler,$item_name)
    {
        $actionct = ActionCt::find()
                                ->select('id')
                                ->where(['id_controler'=>$id_controler])
                                ->asArray()
                                ->all();
        $var = array();
        foreach ($actionct as $data){
            $var[] = $data['id'];
        }
        $query = Acsess::find()->where(['item_name'=>$item_name,'id_action_ct'=>$var]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_action_ct' => $this->id_action_ct,
            'rows' => $this->rows,
        ]);

        $query->andFilterWhere(['like', 'item_name', $this->item_name]);

        return $dataProvider;
    }
    
}
