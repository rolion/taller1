<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of regla
 *
 * @author root
 */
namespace app\SistemaExperto;
use app\SistemaExperto\hecho;
use app\SistemaExperto\literal;
class regla {

    private $antecedente;//conjunto de literales, puede ser atomico;
    private $consecuente;// es un hecho;
    function __construct() {
        $this->antecedente=array();//literales
        $this->consecuente=new hecho();
    }
    
    function getAntecedente() {
        return $this->antecedente;
    }

    function getConsecuente() {
        return $this->consecuente;
    }

    function setAntecedente(array $antecedente) {
        $this->antecedente = $antecedente;
    }
    function addLiteral(literal $literal){
        $this->antecedente[]=$literal;
    }

    function setConsecuente(hecho $consecuente) {
        $this->consecuente = $consecuente;
    }
    function igual($r){
        if($r instanceof regla){
            return $this->comprarLiterales($r->getAntecedente()) && 
                    $this->consecuente->igual($r->getConsecuente());
        }
        return false;
        
    }
    private function comprarLiterales(array $literales){
        $igual=TRUE;
        foreach ($literales as $i =>$l){
            if($this->existeEnArrayAntecendete($l)){
                $igual=TRUE ;
            }  else {
                return false;
            }
           
        } 
        return $igual;
    }
    private function existeEnArrayAntecendete($literal){
        if($literal instanceof literal){
            foreach ($this->antecedente as $l){
                if($literal->igual($l)){
                    return TRUE;
                }
            }
            return FALSE;
        }
    }
    public function clonarAntecedente(){
        $clone = array();
        foreach ($this->antecedente as $regla){
            $clone[]=$regla->clonar();
        }
        return $clone;
    }

}
