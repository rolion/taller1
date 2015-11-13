<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carrera".
 *
 * @property integer $id
 * @property integer $id_area
 * @property string $nombre
 *
 * @property Area $idArea
 */
class Carrera extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'carrera';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_area'], 'required'],
            [['id', 'id_area'], 'integer'],
            [['nombre'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_area' => 'Area',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdArea()
    {
        return $this->hasOne(Area::className(), ['id' => 'id_area']);
    }
}
