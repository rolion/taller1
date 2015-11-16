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
use app\models\ResultadosExamen;
use app\SistemaExperto\backwardchain;
use app\SistemaExperto\hecho;
//use app\
class RespuestaExamenNegocio {
    private $examen;
    private $inscripcion;
    
    
    public function guardarRespuestasAlumno($respuestasAlumno=  array(),$id_inscripcion){
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $inscripcion=  InscripcionExamen::findOne($id_inscripcion);
            $persona=Yii::$app->user->identity->idPersona;
            foreach($respuestasAlumno as $respuesta){
                if($respuesta->id_respuesta!=null && !empty($respuesta->id_respuesta)){
                    $respuesta->save(); 
                    $respuesta->link('idInscripcion',$inscripcion);
                } 
            }
            $inscripcion->fecha_aplicacion=  date('Y-m-d H:i:s');
            $inscripcion->save(false);
            $transaction->commit();
            $sql="CALL obtenerNotas(:id)";
            $command=  \Yii::$app->db->createCommand($sql);
            $command->bindParam(":id", $id_inscripcion, \PDO::PARAM_INT);
            $command->execute();
            $sql="CALL convertirNotasPercentil(:id)";
            $command=  \Yii::$app->db->createCommand($sql);
            $command->bindParam(":id", $id_inscripcion, \PDO::PARAM_INT);
            $command->execute();    
        }catch(yii\db\Exception $e){
            $transaction->rollBack( );
            var_dump($e);
        }
    }
    public function encontrarArea($id_inscripcion){
        $re=new ResultadosExamen();
        $resultados=$re->find()->where(['id_inscripcion'=>$id_inscripcion,'id_tipo'=>2])
                ->limit(3)->orderBy(['nota'=>SORT_DESC])->all();
        foreach ($resultados as $prof){
            $actividad=$re->find()->where(['id_inscripcion'=>$id_inscripcion,'id_tipo'=>1,
                'id_area'=>$prof->id_area])->one();
                if($actividad->nota>$prof->nota){
                    $diferencia=$actividad->nota-$prof->nota;
                }else{
                    $diferencia=$prof->nota-$actividad->nota;
                }
                if( ($diferencia>=0 && $diferencia<=25)){
                    
                    return $prof;
                }
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
