<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "baremo".
 *
 * @property integer $id
 * @property integer $puntiacion_directa
 * @property integer $percentil
 * @property integer $id_area
 *
 * @property Area $idArea
 */
class Baremo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'baremo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['puntiacion_directa', 'percentil', 'id_area'], 'required'],
            [['id', 'puntiacion_directa', 'percentil', 'id_area'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'puntiacion_directa' => 'Puntiacion Directa',
            'percentil' => 'Percentil',
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
}
