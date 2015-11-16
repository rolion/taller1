<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "llave".
 *
 * @property integer $id
 * @property integer $id_colegio
 * @property string $llave
 * @property integer $cantidad
 *
 * @property InscripcionExamen[] $inscripcionExamens
 * @property Colegio $idColegio
 */
class Llave extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'llave';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_colegio','cantidad'],'required'],
            [['id_colegio', 'cantidad'], 'integer'],
            [['llave'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_colegio' => 'Colegio',
            'llave' => 'Llave',
            'cantidad' => 'Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInscripcionExamens()
    {
        return $this->hasMany(InscripcionExamen::className(), ['id_llave' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdColegio()
    {
        return $this->hasOne(Colegio::className(), ['id' => 'id_colegio']);
    }
}
