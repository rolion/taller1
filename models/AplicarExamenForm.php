<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AplicarExamenForm
 *
 * @author root
 */
namespace app\models;
use app\models\Persona;
use app\models\Examen;
use app\models\RespuestaAlumno;
class AplicarExamenForm {
    public $persona;
    public $examen;
    public $respuestaAlumno;
    
    function getRespuestaAlumno() {
        return $this->respuestaAlumno;
    }

    function setRespuestaAlumno($respuestaAlumno) {
        $this->respuestaAlumno = $respuestaAlumno;
    }

        
    function getPersona() {
        return $this->persona;
    }

    function getExamen() {
        return $this->examen;
    }

    function setPersona($persona) {
        $this->persona = $persona;
    }

    function setExamen($examen) {
        $this->examen = $examen;
    }


}
