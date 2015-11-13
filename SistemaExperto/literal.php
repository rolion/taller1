<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of literal
 *
 * @author root
 */
namespace app\SistemaExperto;
use app\SistemaExperto\hecho;
class literal extends hecho {
    private $oprel;
    public static $IGUAL=0;
    public static $MAYOR=1;
    public static $MENOR=2;
    public static $MAYOR_IGUAL=3;
    public static $MENOR_IGUAL=4;
    public static $DIFERENTE=5;
    
    function __construct() {
        
    }
    
    function getOprel() {
        return $this->oprel;
    }

    function setOprel($oprel) {
        $this->oprel = $oprel;
        
    }
    function setHecho(hecho $hecho){
        $this->setVariable($hecho->getVariable());
        $this->setValor($hecho->getValor());
        $this->setEsNumerico($hecho->getEsNumerico());
    }
    function getHecho(){
        $h=new hecho();
        $h->setValor($this->getValor());
        $h->setEsNumerico($this->getEsNumerico());
        $h->setVariable($this->getVariable());
        return $h;
        
    }
    function igual($l){
        if($l instanceof literal){
            $igual;
            $igual=($this->oprel==$l->getOprel()?TRUE:FALSE);
            $igual=$igual&&$this->getHecho()->igual($l->getHecho());
        }
        return FALSE;
    }
    function clonar(){
        $clon=new literal();
        $clon->setHecho($this->getHecho()->clonar());
        $clon->setOprel($this->getOprel());
        return $clon;
    }

}
