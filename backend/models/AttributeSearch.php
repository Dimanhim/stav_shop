<?php

namespace backend\models;

use common\models\AttributeTypeRelation;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Attribute;

/**
 * AttributeSearch represents the model behind the search form of `common\models\Attribute`.
 */
class AttributeSearch extends Attribute
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active', 'deleted', 'position', 'created_at', 'updated_at'], 'integer'],
            [['unique_id', 'attribute_types','name', 'description', 'short_description'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Attribute::find();

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
        if($this->attribute_types) {
            // тут какой то пиздец
            //$attributeIds = AttributeTypeRelation::find()->where(['in', 'attribute_type_id' => $this->attribute_types]);

            //$query->andWhere(['in', ''])
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'is_active' => $this->is_active,
            'deleted' => $this->deleted,
            'position' => $this->position,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'unique_id', $this->unique_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'short_description', $this->short_description]);

        return $dataProvider;
    }
}
