<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OcShare;

/**
 * OcShareSearch represents the model behind the search form about `backend\models\OcShare`.
 */
class OcShareSearch extends OcShare
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'share_type', 'parent', 'file_source', 'permissions', 'stime', 'accepted', 'mail_send'], 'integer'],
            [['share_with', 'uid_owner', 'uid_initiator', 'item_type', 'item_source', 'item_target', 'file_target', 'expiration', 'token'], 'safe'],
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
        $query = OcShare::find();

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
            'share_type' => $this->share_type,
            'parent' => $this->parent,
            'file_source' => $this->file_source,
            'permissions' => $this->permissions,
            'stime' => $this->stime,
            'accepted' => $this->accepted,
            'expiration' => $this->expiration,
            'mail_send' => $this->mail_send,
        ]);

        $query->andFilterWhere(['like', 'share_with', $this->share_with])
            ->andFilterWhere(['like', 'uid_owner', $this->uid_owner])
            ->andFilterWhere(['like', 'uid_initiator', $this->uid_initiator])
            ->andFilterWhere(['like', 'item_type', $this->item_type])
            ->andFilterWhere(['like', 'item_source', $this->item_source])
            ->andFilterWhere(['like', 'item_target', $this->item_target])
            ->andFilterWhere(['like', 'file_target', $this->file_target])
            ->andFilterWhere(['like', 'token', $this->token]);

        return $dataProvider;
    }
}
