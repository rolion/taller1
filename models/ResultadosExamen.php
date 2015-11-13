<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resultados_examen".
 *
 * @property integer $id
 * @property integer $id_examen
 * @property integer $id_area
 * @property integer $nota
 * @property integer $id_inscripcion
 * @property integer $id_tipo
 *
 * @property Area $idArea
 * @property InscripcionExamen $idInscripcion
 * @property Tipo $idTipo
 */
class ResultadosExamen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resultados_examen';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_examen', 'id_area', 'nota', 'id_inscripcion', 'id_tipo'], 'integer'],
            [['id_inscripcion', 'id_tipo'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_examen' => 'Id Examen',
            'id_area' => 'Area',
            'nota' => 'Nota',
            'id_inscripcion' => 'Id Inscripcion',
            'id_tipo' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdArea()
    {
        return $this->hasOne(Area::className(), ['id' => 'id_area']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInscripcion()
    {
        return $this->hasOne(InscripcionExamen::className(), ['id' => 'id_inscripcion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipo()
    {
        return $this->hasOne(Tipo::className(), ['id' => 'id_tipo']);
    }
}
