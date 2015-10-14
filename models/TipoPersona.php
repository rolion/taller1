<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_persona".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 *
 * @property Persona[] $personas
 */
class TipoPersona extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipo_persona';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['id'], 'integer'],
            [['descripcion'], 'string','max' => 255],
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
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas()
    {
        return $this->hasMany(Persona::className(), ['id_tipo' => 'id']);
    }
}
