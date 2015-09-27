<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "area".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property Baremo[] $baremos
 * @property Pregunta[] $preguntas
 * @property ResultadosExamen[] $resultadosExamens
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['nombre'], 'string']
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaremos()
    {
        return $this->hasMany(Baremo::className(), ['id_area' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreguntas()
    {
        return $this->hasMany(Pregunta::className(), ['id_area' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultadosExamens()
    {
        return $this->hasMany(ResultadosExamen::className(), ['id_area' => 'id']);
    }
}
