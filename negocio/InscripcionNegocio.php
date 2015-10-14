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
use app\models\DynamicFormModel;
class InscripcionNegocio {
   
    public function RegistrarInscripcion(&$Persona, $DetalleInscripcion){
       //verificamos si existe la parsona;
        $flag;
        $aux=Persona::find()->where(['ci'=>$Persona->ci])->one();
        $DetalleInscripcion = DynamicFormModel::createMultiple(InscripcionExamen::className());
        DynamicFormModel::loadMultiple($DetalleInscripcion, Yii::$app->request->post());
        $valid = $Persona->validate();
        $valid = DynamicFormModel::validateMultiple($DetalleInscripcion) && $valid;
        if( $aux!=null)//persona existe
        {
            $Persona=$aux;
        }else{
            $Persona->eliminado=0;
            $flag=$Persona->save(false);
        }
        foreach ($DetalleInscripcion as $i => $DetalleInscripcion) {
          //$DetalleInscripcion->idAlumno = $Persona;
          $DetalleInscripcion->fecha_inscripcion= date('Y-m-d H:i:s');
          if (! ($flag = $DetalleInscripcion->save(false))) {
              $transaction->rollBack();
              return false;
          }
          $DetalleInscripcion->link('idAlumno',$Persona);
         }

         return true;
    }
  
}
