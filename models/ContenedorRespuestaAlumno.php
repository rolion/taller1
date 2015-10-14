<?php


namespace app\models;
use Yii;
use yii\base\Model;
use app\models\RespuestaAlumno;
use app\models\RespuestaExamen;



class ContenedorRespuestaAlumno extends Model {
  public $rAlumno;
  public function __construct() {
      $this->rAlumno= [new RespuestaAlumno];
  }
  function getRAlumno() {
      return $this->rAlumno;
  }

  function setRAlumno($idRespuesta) {
      $respuesta=  RespuestaExamen::findOne($idRespuesta);
      foreach ($this->rAlumno as $r){
          if($r->idRespuesta->id_pregunta==$respuesta->id_pregunta){
              unset($r);
          }
      }
      //falta obtener el id de la persona
      $this->rAlumno[]=
      $this->rAlumno = $respuesta;
  }



}
