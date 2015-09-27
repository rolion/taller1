<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resultados_examen".
 *
 * @property integer $id
 * @property integer $id_examen
 * @property integer $id_area
 * @property integer $nota
 * @property integer $id_alumno
 *
 * @property Area $idArea
 * @property Persona $idAlumno
 */
class ResultadosExamen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resultados_examen';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'id_examen', 'id_area', 'nota', 'id_alumno'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_examen' => 'Id Examen',
            'id_area' => 'Id Area',
            'nota' => 'Nota',
            'id_alumno' => 'Id Alumno',
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
    public function getIdAlumno()
    {
        return $this->hasOne(Persona::className(), ['id' => 'id_alumno']);
    }
}
