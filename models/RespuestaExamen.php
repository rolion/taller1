<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "respuesta_examen".
 *
 * @property integer $id
 * @property integer $es_respuesta_correcta
 * @property integer $id_pregunta
 * @property string $nombre_opcion
 * @property resource $imagen
 * @property integer $puntos_otorgados
 * @property integer $eliminado
 * @property string $descripcion_respuesta
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
            [['es_respuesta_correcta', 'puntos_otorgados', 'eliminado'], 'integer'],
            [['imagen', 'descripcion_respuesta'], 'string'],
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
            'es_respuesta_correcta' => 'Es Respuesta Correcta',
            'id_pregunta' => 'Pregunta',
            'nombre_opcion' => 'Nombre Opcion',
            'imagen' => 'Imagen',
            'puntos_otorgados' => 'Puntos Otorgados',
            'eliminado' => 'Eliminado',
            'descripcion_respuesta' => 'Descripcion Respuesta',
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
