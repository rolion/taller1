<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of hecho
 *
 * @author root
 */
namespace app\SistemaExperto;
class hecho {
    //put your code here
    private $variable;
    private $valor;
    private $esNumerico;//boolean
    function getVariable() {
        return $this->variable;
    }

    function getValor() {
        return $this->valor;
    }

    function getEsNumerico() {
        return $this->esNumerico;
    }

    function setVariable($variable) {
        $this->variable = $variable;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setEsNumerico($esNumerico) {
        $this->esNumerico = $esNumerico;
    }
    function igual($object){
        if($object instanceof hecho){
            $igual=(strcmp($this->variable, $object->getVariable())==0?TRUE:FALSE);
            if($this->esNumerico==TRUE && $object->esNumerico==TRUE){
                $igual=$igual&&($this->valor===$object->getValor()?TRUE:FALSE);
                return $igual;
            }
            if($this->esNumerico==FALSE && $object->esNumerico==FALSE){
                $igual=$igual&&(strcmp($this->valor,$object->getValor()==0)?TRUE:FALSE);
                return $igual;
            }
            return false;
            
        }
        
    }
    function clonar(){
        $clon=new hecho();
        $clon->setEsNumerico($this->getEsNumerico());
        $clon->setValor($this->getValor());
        $clon->setVariable($this->getVariable());
        return $clon;
    }

}
