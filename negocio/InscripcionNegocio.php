<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InscripcionNegocio
 *
 * @author root
 */
namespace app\negocio;
use Yii;
use app\models\Persona;
use app\models\InscripcionExamen;
class InscripcionNegocio {
   
    public function RegistrarInscripcion(&$Persona, &$DetalleInscripcion){
       //verificamos si existe la parsona;
       $flag;
       $aux=Persona::find()->where(['ci'=>$Persona->ci])->one();
       
      if( $aux!=null)//persona existe
      {
          $Persona=$aux;
          Yii::error('persona existe');
      }else{
          Yii::error('persona no existe');
          $Persona->eliminado=0;
          $flag=$Persona->save(false);
      }
      foreach ($DetalleInscripcion as $DetalleInscripcion) {
        //$DetalleInscripcion->idAlumno = $Persona;
        Yii::error('asgino id a detalle');
        $DetalleInscripcion->fecha_inscripcion=  date('Y-M-d H:i:s a');
        Yii::error('guardo la fecha');

        if (! ($flag = $DetalleInscripcion->save(false))) {
            Yii::error('error al guardar la transaccion');
            $transaction->rollBack();
            return false;
        }
        $DetalleInscripcion->link('idAlumno',$Persona);
       }

        return true;
    }
  
}
