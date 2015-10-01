<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\negocio;
use app\models\Area;
/**
 * Description of AreaNegocio
 *
 * @author root
 */
class AreaNegocio {
    public function saveArea(&$model){
        if($model->validate()){
            $model->eliminado=0;
            $model->save();
            return true;
        }else 
            return false;
       
    }
    public function updateArea($model){
       // $model=  Area::findOne($id);
        if($this->saveArea($model)){
            return $model;
        }else
            return null;
    }
    public function deleteArea($id){
        $model=  Area::findOne($id);
        $model->eliminado=1;
        if($model->save()){
            return true;
        }else
            return false;
    }
}
