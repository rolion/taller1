<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "examen".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $autor
 * @property string $fecha_publicacion
 * @property integer $elimnado
 *
 * @property InscripcionExamen[] $inscripcionExamens
 * @property Pregunta[] $preguntas
 */
class Examen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'examen';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'],'required'],
            [['nombre', 'autor'], 'string', 'max' => 255],
            [['fecha_publicacion'], 'safe'],
            [['eliminado'], 'integer']
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
            'autor' => 'Autor',
            'fecha_publicacion' => 'Fecha Publicacion',
            'elimnado' => 'Elimnado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInscripcionExamens()
    {
        return $this->hasMany(InscripcionExamen::className(), ['id_examen' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreguntas()
    {
        return $this->hasMany(Pregunta::className(), ['id_examen' => 'id'])->orderBy('nro_pregunta');
    }
}
