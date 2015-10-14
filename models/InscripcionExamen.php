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
 * @property double $costo
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
            [['id_alumno', 'id_examen', 'eliminado'], 'integer'],
            [['fecha_inscripcion', 'fecha_aplicacion'], 'safe'],
            [['fecha_inscripcion','fecha_aplicacion'],'date','format' => 'yyyy-mm-dd'],
            [['id_examen','costo'], 'required'],
            [['costo'], 'number']
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
            'costo' => 'Costo',
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
