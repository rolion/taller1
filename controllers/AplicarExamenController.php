<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\Persona;
use app\models\InscripcionExamen;
use app\negocio\ExamenNegocio;
use app\models\RespuestaAlumno;
use app\models\DynamicFormModel;
use yii\data\ActiveDataProvider;
use app\negocio\RespuestaExamenNegocio;
use app\models\ResultadosExamen;
use  yii\web\Session;
use app\models\Carrera;

class AplicarExamenController extends Controller {
    
    
    public function actionIndex(){
        $persona=new Persona();
     
            $persona=Yii::$app->user->identity->idPersona;
            $dataProvider = new ActiveDataProvider([
                'query' => InscripcionExamen::find()->where(['id_alumno'=>$persona->id
                ,'eliminado'=>0]),
            ]);
            
            return $this->render('index',[
                'dataProvider' => $dataProvider,
            ]);    
    }
    public function actionAplicar($id){
        $session=  Yii::$app->session;
        if(!$session->isActive){
            $session->open();
        }
        $session->set('id_inscripcion', $id);
        $examenNegocio=new ExamenNegocio();
        $inscripcion=  InscripcionExamen::findOne($id);
        $examen=  $inscripcion->idExamen; //Examen::findOne($id);
        $preguntas= $examenNegocio->getPreguntasExamen($inscripcion->id_examen);
        $respuestasAlumno=RespuestaAlumno::find()->where(['id_inscripcion'=>$id])->all();
        if($respuestasAlumno==null || empty($respuestasAlumno)){
            foreach ($preguntas as $i=> $pregunta){
            $respuestasAlumno[]=new RespuestaAlumno();
            }
        }
        
        
         return $this->render('aplicar-examen', [
             'examen' => $examen,
             'preguntas'=>$preguntas,
             'respuestasAlumno'=>$respuestasAlumno,
             'idInscripcion'=>$id,
         ]);   
    }
    public function actionSistemaExperto($id){

        $negocio=new RespuestaExamenNegocio();
        $perfil=$negocio->procesarRespuestas($id);
        $resultadosExamen= new ResultadosExamen();
        $dataProvider = new ActiveDataProvider([
                'query' => ResultadosExamen::
                find()->where(['id_inscripcion'=>$id])->orderBy(['id_area'=>SORT_ASC]),
            ]);
        if($perfil!=null)
            $valor=$perfil->getValor();
        else
            $valor='no se encontro un resultado';
        if(strcasecmp($valor, \app\SistemaExperto\backwardchain::$DEFINIDO)==0){
            $profesion=$negocio->encontrarArea($id);
            $carrera=new ActiveDataProvider([ 'query'=>
                Carrera::find()->where(['id_area'=>$profesion->id_area])]);
                   
        }else{
            $profesion=null;
            $carrera=null;
        }
        
        return $this->render('resultado',['dataProvider'=>$dataProvider,
            'perfil'=>$valor,
            'profesion'=>$profesion,
            'carrera'=>$carrera]);
    }
    public function actionGuardarRespuesta(){        
        $id_inscripcion= Yii::$app->session->get('id_inscripcion');
        $respuestasAlumno = DynamicFormModel::createMultiple(RespuestaAlumno::className());
        DynamicFormModel::loadMultiple($respuestasAlumno, Yii::$app->request->post());
        $valid =  DynamicFormModel::validateMultiple($respuestasAlumno) ;
        if($valid){
            $negocio=new RespuestaExamenNegocio();
            $negocio->guardarRespuestasAlumno($respuestasAlumno, $id_inscripcion);
        }
        Yii::$app->session->remove('id_inscripcion');
        Yii::$app->session->close();

        return $this->redirect(['index']);
        
    }
}
