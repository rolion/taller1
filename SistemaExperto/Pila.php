<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pila
 *
 * @author root
 */
namespace app\SistemaExperto;
use hecho\hecho;
class Pila {
    var $pila;
    function __construct() {
        $this->pila=array();
    }
    function push(hecho $hecho){
        $this->pila[]=$hecho;
    }
    function pop(){
        return array_pop( $this->pila );
        
    }
    public function isEmpty()
    {
            return empty( $this->pila);
    }

    public function getLength()
    {
            return count( $this->pila );
    }

}
