<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "respuesta_alumno".
 *
 * @property integer $id
 * @property integer $id_respuesta
 * @property integer $id_alumno
 *
 * @property Persona $idAlumno
 * @property RespuestaExamen $idRespuesta
 */
class RespuestaAlumno extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'respuesta_alumno';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_respuesta', 'id_alumno'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_respuesta' => 'Id Respuesta',
            'id_alumno' => 'Id Alumno',
        ];
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
    public function getIdRespuesta()
    {
        return $this->hasOne(RespuestaExamen::className(), ['id' => 'id_respuesta']);
    }
}
