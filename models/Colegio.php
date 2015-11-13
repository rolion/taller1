<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "colegio".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $direccion
 * @property string $telefono
 * @property integer $eliminado
 *
 * @property Persona[] $personas
 */
class Colegio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'colegio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['eliminado'], 'integer'],
            [['nombre', 'direccion'], 'string', 'max' => 255],
            [['telefono'], 'string', 'max' => 10]
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
            'direccion' => 'Direccion',
            'telefono' => 'Telefono',
            'eliminado' => 'Eliminado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas()
    {
        return $this->hasMany(Persona::className(), ['id_colegio' => 'id']);
    }
}
