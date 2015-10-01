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
           $model->save();
           return true;
       }else
           return false;
   } 
   public function logicalDelete($id){
       $model;
       if($model=Baremo::findOne($id)!=null){
           $model->elimnado=1;
           $model->save();
       }
   }
}
