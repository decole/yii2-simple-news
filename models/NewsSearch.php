<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\News;

/**
 * NewsSearch represents the model behind the search form about `app\models\News`.
 */
class NewsSearch extends News
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'published', 'deleted', 'user_id'], 'integer'],
            [['title', 'preview_text', 'detail_text', 'create_date', 'update_date'], 'safe'],
            // добавить в правило от и до
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
        $query = News::find();

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

        //объявить в клаее publick $create_from $create_to сверху

//        if () {  если поле есть то добавляем и если до то добовляем
//            $query->andWhere(['>', 'create_date', $this->create_from]);
//        }
        // добавить в форму 2 поля от и до

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'published' => $this->published,
            'deleted' => $this->deleted,
            'user_id' => $this->user_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);



        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'preview_text', $this->preview_text])
            ->andFilterWhere(['like', 'detail_text', $this->detail_text]);

        return $dataProvider;
    }
}
