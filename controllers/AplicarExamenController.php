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

class AplicarExamenController extends Controller {
    
    
    public function actionIndex(){
        $persona=new Persona();
        if(!Yii::$app->user->isGuest){//esta logeado
            $persona=Yii::$app->user->identity->idPersona;
            $dataProvider = new ActiveDataProvider([
                'query' => InscripcionExamen::find()->where(['id_alumno'=>$persona->id
                ,'eliminado'=>0]),
            ]);
            
            return $this->render('index',[
                'dataProvider' => $dataProvider,
            ]);
        }else{
            return $this->goHome();
        }    
    }
    public function actionAplicar($id){
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
        
        if($preguntas!=null && !empty($preguntas)){
         return $this->render('aplicar-examen', [
             'examen' => $examen,
             'preguntas'=>$preguntas,
             'respuestasAlumno'=>$respuestasAlumno,
             'idInscripcion'=>$id,
         ]);   
        }
        return $this->goHome();
    }
    public function actionSistemaExperto($id){
        $negocio=new RespuestaExamenNegocio();
        $perfil=$negocio->procesarRespuestas($id);
        $resultadosExamen= new ResultadosExamen();
        //$resultado=$resultadosExamen->find()->where(['id_inscripcion'=>$id])->orderBy(['id_area'=>SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
                'query' => ResultadosExamen::
                find()->where(['id_inscripcion'=>$id])->orderBy(['id_area'=>SORT_ASC]),
            ]);
        if($perfil!=null)
            $valor=$perfil->getValor();
        else
            $valor='no se encontro un resultado';
        return $this->render('resultado',['dataProvider'=>$dataProvider,'perfil'=>$valor]);
    }
    public function actionGuardarRespuesta(){        
        $id_examen;
        $respuestasAlumno = DynamicFormModel::createMultiple(RespuestaAlumno::className());
        DynamicFormModel::loadMultiple($respuestasAlumno, Yii::$app->request->post());
        $valid =  DynamicFormModel::validateMultiple($respuestasAlumno) ;
        if($valid){
            $negocio=new RespuestaExamenNegocio();
            $negocio->guardarRespuestasAlumno($respuestasAlumno);
        }
        return $this->redirect(['index']);
        
    }
}
