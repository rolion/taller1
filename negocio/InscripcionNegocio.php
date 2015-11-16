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
use app\models\Llave;
class InscripcionNegocio {
    
    public function inscripcionPorLlave($model){
        $llave=  Llave::find()->where(['llave'=>$model->llave])->one();
            if($llave!=null && !empty($llave)){
                $examen=  \app\models\Examen::findOne($model->id_examen);
                $inscripcion=new InscripcionExamen();
                $persona=Yii::$app->user->identity->idPersona;
                if($persona->id_colegio==$llave->id_colegio){
                    $inscripcion->fecha_inscripcion=date('Y-m-d H:i:s');
                    $inscripcion->eliminado=0;
                    if($inscripcion->save(false)){
                        $inscripcion->link('idAlumno', $persona);
                        $inscripcion->link('idExamen', $examen);
                        $inscripcion->link('idLlave', $llave);
                        return true;
                    }
                    return false;
                }
                return false;
                
            }
            return false;
    }
   
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
          $DetalleInscripcion->eliminado=0;
          if (! ($flag = $DetalleInscripcion->save(false))) {
              $transaction->rollBack();
              return false;
          }
          $DetalleInscripcion->link('idAlumno',$Persona);
         }

         return true;
    }
  
}
