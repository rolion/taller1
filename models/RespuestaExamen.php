<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "respuesta_examen".
 *
 * @property integer $id
 * @property string $descripcion_respuesta
 * @property integer $id_pregunta
 * @property string $nombre_opcion
 * @property resource $imagen
 * @property integer $puntos_otorgados
 *
 * @property RespuestaAlumno[] $respuestaAlumnos
 * @property Pregunta $idPregunta
 */
class RespuestaExamen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $imgfile;
    public static function tableName()
    {
        return 'respuesta_examen';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion_respuesta','puntos_otorgados','nombre_opcion'],'required'],
            [['descripcion_respuesta', 'imagen'], 'string'],
            [['id_pregunta', 'puntos_otorgados'], 'integer'],
            [['imgfile'],'file','extensions'=>'jpg, png'],
            [['nombre_opcion'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion_respuesta' => 'Descripcion Respuesta',
            'id_pregunta' => 'Pregunta',
            'nombre_opcion' => 'Nombre Opcion',
            'imagen' => 'Imagen',
            'puntos_otorgados' => 'Puntos Otorgados',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRespuestaAlumnos()
    {
        return $this->hasMany(RespuestaAlumno::className(), ['id_respuesta' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPregunta()
    {
        return $this->hasOne(Pregunta::className(), ['id' => 'id_pregunta']);
    }
}
