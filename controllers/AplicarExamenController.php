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
use app\models\Examen;
use app\negocio\ExamenNegocio;
use app\models\RespuestaAlumno;
use app\models\DynamicFormModel;
use yii\data\ActiveDataProvider;

class AplicarExamenController extends Controller {
    
    
    public function actionIndex(){
        $persona=new Persona();
        $inscripcion=new InscripcionExamen();
        $examenes=[new Examen];
        if(!Yii::$app->user->isGuest){//esta logeado
            $persona=Yii::$app->user->identity->idPersona;
            $dataProvider = new ActiveDataProvider([
                'query' => InscripcionExamen::find()->where(['id_alumno'=>$persona->id
                ,'eliminado'=>0,'fecha_aplicacion'=>null]),
            ]);
            $inscripcion=$persona->inscripcionExamens;
            foreach ($inscripcion as $i=>$inscrip){
                $examenes[$i]=$inscrip->idExamen;
            }
            
            return $this->render('index',[
                'examenes'=>$examenes,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            return $this->goHome();
            //redirigir a una pagina de error
        }
//        return $this->render('index', [
//            'dataProvider' => $dataProvider,
//        ]);    
    }
    public function actionAplicar($id){
        $examenNegocio=new ExamenNegocio();
        $examen=  Examen::findOne($id);
        $preguntas= $examenNegocio->getPreguntasExamen($id);
        $respuestasAlumno=[new RespuestaAlumno()];
        if($preguntas!=null && !empty($preguntas)){
         return $this->render('aplicar-examen', [
             'examen' => $examen,
             'preguntas'=>$preguntas,
             'respuestasAlumno'=>$respuestasAlumno,
         ]);   
        }
        return $this->goHome();
         
    }
    public function actionGuardarRespuesta(){
        $respuestasAlumno=[new RespuestaAlumno()];
        $respuestasAlumno = DynamicFormModel::createMultiple(RespuestaAlumno::className());
        DynamicFormModel::loadMultiple($respuestasAlumno, Yii::$app->request->post());
        $valid =  DynamicFormModel::validateMultiple($modelRespuestaExamen) ;
        if($valid){
            ;
        }
    }
}
