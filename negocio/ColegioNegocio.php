<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\negocio;
use app\models\Colegio;
/**
 * Description of ColegioNegocio
 *
 * @author root
 */
class ColegioNegocio {
    public function saveColegio(&$model){
        if ($model->validate()) {
            $model->eliminado = 0;
            $model->save();
            return true;
        } else {
            return false;
        }
    }
    public function updateColegio($model){
       // $model=  Area::findOne($id);
       if ($this->saveArea($model)) {
            return $model;
        } else {
            return null;
        }
    }
    public function deleteColegio($id){
        $model= Colegio::findOne($id);
        $model->eliminado=1;
        if ($model->save()) {
            return true;
        } else {
            return false;
        }
    }
}
