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
use app\models\Usuario;
use app\models\Llave;
class PersonaNegocio {
    
    
    public function savePersona($persona){
        if($persona!=null){
            //validar que el ci no exista
           //la persona no existe
                $persona->eliminado=0;
                $usuario=new Usuario();
                $usuario->usuario=$persona->nick;
                $usuario->contrasenha=$persona->pass;
                $persona->id_tipo=1;
                $persona->save(false);
                $usuario->id_persona=$persona->id;
                $usuario->save();
                return true;
            }
    }
    private function llaveExiste($llave){
        $l=new Llave();
        $result=$l->find()->where(['llave',$llave]);
        if($result!=null && count($result)>0){
            return true;
        }
        return false;
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
