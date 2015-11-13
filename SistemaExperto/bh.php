<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bh
 *
 * @author root
 */
namespace app\SistemaExperto;
use app\SistemaExperto\hecho;
class bh {
    private $hechos;
    function __construct() {
        $this->hechos=array();
    }

    function getHechos() {
        return $this->hechos;
    }

    function setHechos($hechos) {
        $this->hechos = $hechos;
    }

    function addHecho($hecho){
        if(!$this->existe($hecho)){
            $this->hechos[]=$hecho;
        }
    }
    function existe(hecho $hecho){
        foreach ($this->hechos as $i => $h){
            if(strcmp($hecho->getVariable(), $h->getVariable())==0){
                return true;
            }
        }
        return false;
    }
    function existeHecho(hecho $hecho){
        foreach ($this->hechos as $i => $h){
            if(strcmp($hecho->getVariable(), $h->getVariable())==0){
                return $h;
            }
        }
        return NULL;
    }
}
