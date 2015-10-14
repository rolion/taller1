<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PersonaNegocio
 *
 * @author root
 */
namespace app\negocio;
use app\models\Persona;
class PersonaNegocio {
    
    
    public function savePersona($persona){
        if($persona!=null){
            //validar que el ci no exista
            if(Persona::findOne(['eliminado'=>0,'ci'=>$persona->ci])==null 
                    && $persona->validate()){//la persona no existe
                $persona->eliminado=0;
                $persona->save(false);
                return true;
            }
            return false;
        }
    }
    public function updatePersona($persona){
        if($persona!=null){
            if($persona->validate()){
                $persona->save(false);
                return true;
            }
            return false;
        }
    }
    public function deletePersona($persona){
        if($persona!=null){
            $persona->eliminado=1;
            $persona->save();
            return true;
        }
        return false;
    }
}
