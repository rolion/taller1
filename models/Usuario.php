<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "usuario".
 *
 * @property integer $id
 * @property string $usuario
 * @property string $contrasenha
 * @property integer $id_persona
 *
 * @property Persona $idPersona
 */
class Usuario extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public $rememberMe = true;
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario','contrasenha'], 'required'],
            [['id', 'id_persona'], 'integer'],
            [['usuario'], 'string', 'max' => 50],
            ['rememberMe', 'boolean'],
            [['contrasenha'], 'string', 'max' => 8]
        ];
    }
    function getRememberMe() {
        return $this->rememberMe;
    }

    function setRememberMe($rememberMe) {
        $this->rememberMe = $rememberMe;
    }
    
    public function validatePassword($pass){
        $this->contrasenha==$pass;
    }

    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario' => 'Usuario',
            'contrasenha' => 'Contraseña',
            'id_persona' => 'Persona',
            'rememberMe'=>'Recuerdame'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPersona()
    {
        return $this->hasOne(Persona::className(), ['id' => 'id_persona']);
    }

    public function getAuthKey() {
        return $this->id;
    }

    public function getId() {
        return $this->id;
    }
    
    public function logIn(){
        $user=  static::find()->where(['usuario'=>  
            $this->usuario,'contrasenha'=>$this->contrasenha])->one();
        return $user;
    }

    public function validateAuthKey($authKey) {
        return $this->id=$authKey;
    }

    public static function findIdentity($id) {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        if($token!=null){
            ;
        }
    }

}
