<?php

namespace app\models;

use Yii;
use yii\base\Model;
class ModelInscripcion extends Model {
   public $id_examen;
   public $llave;
   
     public function rules()
    {
        return [
            // username and password are both required
            [['id_examen','llave'], 'required'],
            // rememberMe must be a boolean value
            ['id_examen', 'integer'],
            // password is validated by validatePassword()
            ['llave', 'string'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id_examen' => 'Examen',
            'llave'=>'Llave',
        ];
    }
}
