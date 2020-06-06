<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Radicados;
use yii\db\Query;
use yii\helpers\VarDumper;

/**
 * RadicadosSearch represents the model behind the search form of `app\models\Radicados`.
 */
class RadicadosSearch extends Radicados
{
    public $email;
    public $temas;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'numero_radicado', 'estado'], 'integer'],
            [['titulo', 'temas', 'fecha', 'email','hora'], 'safe'],
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
        $query = new Query();
        $query->select([
            'rad.id',
            'rad.numero_radicado',
            'rad.titulo',
            'u.email',
            'rad.fecha',
            'rad.hora',
            'rad.estado'
        ])
        ->from(['rad' => 'radicados'])
        ->leftJoin(['u' => 'users'], 'u.id=rad.user_id')
        ->orderBy('rad.fecha_registro desc');

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
            'user_id' => $this->user_id,
            'numero_radicado' => $this->numero_radicado,
            'estado' => $this->estado,
            'fecha' => $this->fecha,
        ]);

        $query->andFilterWhere(['ilike', 'titulo', $this->titulo])
            ->andFilterWhere(['ilike', 'temas', $this->temas])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'hora', $this->hora]);

        return $dataProvider;
    }
}
