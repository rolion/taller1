<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "persona".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $apellido
 * @property string $telefono
 * @property integer $ci
 * @property integer $id_tipo
 * @property integer $eliminado
 * @property integer $id_colegio
 *
 * @property InscripcionExamen[] $inscripcionExamens
 * @property Colegio $idColegio
 * @property TipoPersona $idTipo
 * @property RespuestaAlumno[] $respuestaAlumnos
 * @property ResultadosExamen[] $resultadosExamens
 */
class Persona extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'persona';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'ci', 'id_tipo', 'eliminado', 'id_colegio'], 'integer'],
            [['nombre', 'apellido'], 'string', 'max' => 255],
            [['telefono'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'telefono' => 'Telefono',
            'ci' => 'Ci',
            'id_tipo' => 'Id Tipo',
            'eliminado' => 'Eliminado',
            'id_colegio' => 'Id Colegio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInscripcionExamens()
    {
        return $this->hasMany(InscripcionExamen::className(), ['id_alumno' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdColegio()
    {
        return $this->hasOne(Colegio::className(), ['id' => 'id_colegio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipo()
    {
        return $this->hasOne(TipoPersona::className(), ['id' => 'id_tipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRespuestaAlumnos()
    {
        return $this->hasMany(RespuestaAlumno::className(), ['id_alumno' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultadosExamens()
    {
        return $this->hasMany(ResultadosExamen::className(), ['id_alumno' => 'id']);
    }
}
