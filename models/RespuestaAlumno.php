<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "respuesta_alumno".
 *
 * @property integer $id
 * @property integer $id_respuesta
 * @property integer $id_inscripcion
 *
 * @property InscripcionExamen $idInscripcion
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
            [['id_respuesta'],'required'],
            [['id_respuesta', 'id_inscripcion'], 'integer']
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
            'id_inscripcion' => 'Id Inscripcion',
        ];
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
    public function getIdRespuesta()
    {
        return $this->hasOne(RespuestaExamen::className(), ['id' => 'id_respuesta']);
    }

}
