<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\Examen;
use app\models\RespuestaAlumno;
use app\models\RespuestaExamen;
use app\models\Pregunta;
use app\negocio\ExamenNegocio;
use app\models\DynamicFormModel;

class AplicarExamenController extends Controller {
    
    
    public function actionIndex($id){
        $examenNegocio=new ExamenNegocio();
        $examen=  Examen::findOne($id);
        $preguntas= $examenNegocio->getPreguntasExamen($id);
        $respuestasAlumno=[new RespuestaAlumno()];
//        $aux=ArrayHelper::map( RespuestaExamen::
//                                find()->where(['id_pregunta'=>26])->all(),
//                                    'id', 'descripcion_respuesta');
//        $respuestasAlumno=[new RespuestaAlumno];
//        foreach ($preguntas as $i=> $pregunta){
//            $aux=ArrayHelper::map( RespuestaExamen::
//                                find()->where(['id_pregunta'=>$pregunta->id])->all(),
//                                    'id', 'descripcion_respuesta');
//        }
         return $this->render('aplicar-examen', [
             'examen' => $examen,
             'preguntas'=>$preguntas,
             'respuestasAlumno'=>$respuestasAlumno,
         ]);
        
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
