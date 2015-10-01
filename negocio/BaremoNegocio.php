<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\negocio;
use app\models\Baremo;
/**
 * Description of BaremoNegocio
 *
 * @author root
 */
class BaremoNegocio {
    
    
   public function saveBaremo(&$model){
       
       $valid=$model->validate();
       if($valid){
           $model->eliminado=0;
           $model->save();
           return true;
       }else
           return false;
   } 
   public function deleteArea($id){
        $model= Baremo::findOne($id);
        $model->eliminado=1;
        if($model->save()){
            return true;
        }else
            return false;
   }
   public function updateBaremo($model){
       if($this->saveBaremo($model))
           return $model;
       else 
           return null;
       
   }
}
