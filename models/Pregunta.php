<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pregunta".
 *
 * @property integer $id
 * @property string $descripcion_pregunta
 * @property integer $id_examen
 * @property resource $imagen
 * @property integer $id_area
 *
 * @property Area $idArea
 * @property Examen $idExamen
 * @property RespuestaExamen[] $respuestaExamens
 */
class Pregunta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;
    public static function tableName()
    {
        return 'pregunta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion_pregunta', 'imagen'], 'string'],
            ['file','file','extensions'=>'jpg, png'],
            [['id_examen', 'id_area'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion_pregunta' => 'Descripcion Pregunta',
            'id_examen' => 'Examen',
            'file' => 'Imagen',
            'id_area' => 'Area',
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
    public function getIdExamen()
    {
        return $this->hasOne(Examen::className(), ['id' => 'id_examen']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRespuestaExamens()
    {
        return $this->hasMany(RespuestaExamen::className(), ['id_pregunta' => 'id']);
    }
}
