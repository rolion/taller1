<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inscripcion_examen".
 *
 * @property integer $id
 * @property integer $id_alumno
 * @property integer $id_examen
 * @property string $fecha_inscripcion
 * @property string $fecha_aplicacion
 * @property integer $eliminado
 * @property double $costo
 * @property integer $id_llave
 *
 * @property Llave $idLlave
 * @property Examen $idExamen
 * @property Persona $idAlumno
 * @property RespuestaAlumno[] $respuestaAlumnos
 * @property ResultadosExamen[] $resultadosExamens
 */
class InscripcionExamen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inscripcion_examen';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_alumno', 'id_examen', 'eliminado', 'id_llave'], 'integer'],
            [['fecha_inscripcion', 'fecha_aplicacion'],'safe'],
            [['fecha_inscripcion', 'fecha_aplicacion'], 'date','format' => 'yyyy-mm-dd'],
            [['costo'], 'number'],
            [['fecha_inscripcion'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_alumno' => 'Alumno',
            'id_examen' => 'Examen',
            'fecha_inscripcion' => 'Fecha Inscripcion',
            'fecha_aplicacion' => 'Fecha Aplicacion',
            'eliminado' => 'Eliminado',
            'costo' => 'Costo',
            'id_llave' => 'Id Llave',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdLlave()
    {
        return $this->hasOne(Llave::className(), ['id' => 'id_llave']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdExamen()
    {
        return $this->hasOne(Examen::className(), ['id' => 'id_examen']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAlumno()
    {
        return $this->hasOne(Persona::className(), ['id' => 'id_alumno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRespuestaAlumnos()
    {
        return $this->hasMany(RespuestaAlumno::className(), ['id_inscripcion' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultadosExamens()
    {
        return $this->hasMany(ResultadosExamen::className(), ['id_inscripcion' => 'id']);
    }
}
