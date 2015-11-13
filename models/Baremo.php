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
 * @property integer $id_tipo
 * @property integer $eliminado
 *
 * @property Tipo $idTipo
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
            [['puntiacion_directa', 'percentil', 'id_area', 'id_tipo', 'eliminado'], 'integer'],
            [['id_tipo'], 'required']
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
            'id_area' => 'Id Area',
            'id_tipo' => 'Id Tipo',
            'eliminado' => 'Eliminado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
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
}
