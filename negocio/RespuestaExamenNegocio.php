<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RespuestaExamenNegocio
 *
 * @author root
 */
namespace app\negocio;

use Yii;
use app\models\InscripcionExamen;
use app\models\RespuestaAlumno;
use app\SistemaExperto\backwardchain;
use app\SistemaExperto\hecho;
//use app\
class RespuestaExamenNegocio {
    private $examen;
    private $inscripcion;
    
    
    public function guardarRespuestasAlumno($respuestasAlumno=  array()){
        $transaction = Yii::$app->db->beginTransaction();
        $id=null;
        try{
            $persona=Yii::$app->user->identity->idPersona;
            foreach($respuestasAlumno as $respuesta){
                if($respuesta->id_respuesta!=null && !empty($respuesta->id_respuesta)){
                    $id_examen=$respuesta->idRespuesta->idPregunta->id_examen;
                    $examen=$this->getExamen($respuesta);
                    $respuesta->save();
                    $inscripcion= $this->getInscripcion($persona->id, $examen);
                    $respuesta->link('idInscripcion',$inscripcion);     
                } 
            }
            $this->inscripcion->fecha_aplicacion=  date('Y-m-d H:i:s');
            $this->inscripcion->save(false);
            $id= $this->inscripcion->id;
            $transaction->commit();
            $sql="CALL obtenerNotas(:id)";
            $command=  \Yii::$app->db->createCommand($sql);
            $command->bindParam(":id", $id, \PDO::PARAM_INT);
            $command->execute();
            $sql="CALL convertirNotasPercentil(:id)";
            $command=  \Yii::$app->db->createCommand($sql);
            $command->bindParam(":id", $id, \PDO::PARAM_INT);
            $command->execute();    
        }catch(yii\db\Exception $e){
            $transaction->rollBack( );
            var_dump($e);
        }
    }
    public function procesarRespuestas($id){
        
        $SE=new backwardchain();
        $SE->initBase($id);
        $SE->createRules();
        $meta=new hecho();
        $meta->setVariable('perfil');
        return $SE->bwcr($meta);
     
    }


    private function getInscripcion($id_persona,$examen){
        if($this->inscripcion==null || empty($this->inscripcion)){
            $this->inscripcion=  InscripcionExamen::find()
                ->where(['id_alumno'=>$id_persona,'id_examen'=>$examen->id,
                                    'fecha_aplicacion'=>null])
                ->one();
        }
        return $this->inscripcion;
    }
    private function getExamen(RespuestaAlumno $respuesta){
        if($this->examen==null || empty($this->examen)){
            $this->examen=$respuesta->idRespuesta->idPregunta->idExamen;
        }
        return $this->examen;
    }
}
