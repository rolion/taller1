<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "persona".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $apellido
 * @property string $telefono
 * @property integer $ci
 * @property integer $id_tipo
 * @property integer $eliminado
 * @property integer $id_colegio
 *
 * @property InscripcionExamen[] $inscripcionExamens
 * @property Colegio $idColegio
 * @property TipoPersona $idTipo
 * @property RespuestaAlumno[] $respuestaAlumnos
 * @property ResultadosExamen[] $resultadosExamens
 */
class Persona extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    
    private $nick;
    private $pass;
    private $llave;
    public static function tableName()
    {
        return 'persona';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre','apellido','ci','id_colegio','nick','pass',], 'required'],
            [['id', 'ci', 'id_tipo', 'eliminado', 'id_colegio'], 'integer'],
            [['nombre', 'apellido','ciudad'], 'string', 'max' => 255],
            [['nick','pass'],'string','max'=>8],
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
            'apellido' => 'Apellido',
            'telefono' => 'Telefono',
            'ci' => 'C.I.',
            'id_tipo' => 'Tipo',
            'eliminado' => 'Eliminado',
            'id_colegio' => 'Colegio',
            'nick'=>'Nombre Cuenta',
            'pass'=>'Contraseña'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInscripcionExamens()
    {
        return $this->hasMany(InscripcionExamen::className(), ['id_alumno' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdColegio()
    {
        return $this->hasOne(Colegio::className(), ['id' => 'id_colegio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipo()
    {
        return $this->hasOne(TipoPersona::className(), ['id' => 'id_tipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRespuestaAlumnos()
    {
        return $this->hasMany(RespuestaAlumno::className(), ['id_alumno' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultadosExamens()
    {
        return $this->hasMany(ResultadosExamen::className(), ['id_alumno' => 'id']);
    }
    function getNick() {
        return $this->nick;
    }

    function getPass() {
        return $this->pass;
    }

    function setNick($nickname) {
        $this->nick = $nickname;
    }

    function setPass($pass) {
        $this->pass = $pass;
    }

    function getLlave() {
        return $this->llave;
    }

    function setLlave($llave) {
        $this->llave = $llave;
    }


}
