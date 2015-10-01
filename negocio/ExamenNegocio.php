<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExamenNegocio
 *
 * @author root
 */
namespace app\negocio;
use app\models\Examen;
class ExamenNegocio {
    public function saveExamen(&$model){
        if($model->validate()){
            $model->eliminado=0;
            $model->save();
            return true;
        }else 
            return false;
       
    }
    public function updateExamen($model){
       // $model=  Area::findOne($id);
        if($this->saveExamen($model)){
            return $model;
        }else
            return null;
    }
    public function deleteExamen($id){
        $model= Examen::findOne($id);
        $model->eliminado=1;
        if($model->save()){
            return true;
        }else
            return false;
    }
}
