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
 *
 * @property Examen $idExamen
 * @property Persona $idAlumno
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
            [['id'], 'required'],
            [['id', 'id_alumno', 'id_examen', 'eliminado'], 'integer'],
            [['fecha_inscripcion', 'fecha_aplicacion'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_alumno' => 'Id Alumno',
            'id_examen' => 'Id Examen',
            'fecha_inscripcion' => 'Fecha Inscripcion',
            'fecha_aplicacion' => 'Fecha Aplicacion',
            'eliminado' => 'Eliminado',
        ];
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
}
