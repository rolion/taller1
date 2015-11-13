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
 * @property integer $nro_pregunta
 * @property integer $eliminado
 * @property integer $id_tipo
 *
 * @property Tipo $idTipo
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
            [['id_area','descripcion_pregunta','id_examen','nro_pregunta'],'required'],
            [['descripcion_pregunta', 'imagen'], 'string'],
            [['file'],'file','extensions'=>'jpg, png'],
            [['id_examen', 'id_area', 'nro_pregunta', 'eliminado', 'id_tipo'], 'integer']
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
            'id_examen' => 'Id Examen',
            'imagen' => 'Imagen',
            'id_area' => 'Id Area',
            'file' => 'Imagen',
            'nro_pregunta' => 'Nro Pregunta',
            'eliminado' => 'Eliminado',
            'id_tipo' => 'Id Tipo',
            'examenName'=>Yii::t('app', 'Examen'),
            'areaName'=>Yii::t('app', 'Area'),
            'tipoArea'=>Yii::t('app', 'Tipo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoArea(){
        return $this->idTipo->nombre;
    }
    public function getExamenName(){
        
        return $this->idExamen->nombre;
    }
    public function getAreaName(){
        return $this->idArea->nombre;
    }
    public function getIdTipo()
    {
        return $this->hasOne(Tipo::className(), ['id' => 'id_tipo']);
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
