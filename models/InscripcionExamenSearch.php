<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InscripcionExamen;

/**
 * InscripcionExamenSearch represents the model behind the search form about `app\models\InscripcionExamen`.
 */
class InscripcionExamenSearch extends InscripcionExamen
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_alumno', 'id_examen', 'eliminado'], 'integer'],
            [['fecha_inscripcion', 'fecha_aplicacion'], 'safe'],
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
        $query = InscripcionExamen::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_alumno' => $this->id_alumno,
            'id_examen' => $this->id_examen,
            'fecha_inscripcion' => $this->fecha_inscripcion,
            'fecha_aplicacion' => $this->fecha_aplicacion,
            'eliminado' => $this->eliminado,
        ]);

        return $dataProvider;
    }
}
