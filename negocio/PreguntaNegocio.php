<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\negocio;
use Yii;
use app\models\RespuestaExamen;
use yii\web\UploadedFile;
use app\models\DynamicFormModel;
use yii\helpers\ArrayHelper;
use app\models\Pregunta;
/**
 * Description of PreguntaNegocio
 *
 * @author root
 */
class PreguntaNegocio {
    private $imgaName;
    public function savePregunta1(&$model,&$modelRespuestaExamen){
        $transaction = Yii::$app->db->beginTransaction();
        try{
        $model->imagen='uploads/null.png';
        $model->eliminado=0;
        $model->save();
        //f(empty($modelRespuestaExamen)){
            $respuesta=new RespuestaExamen();
            $respuesta->descripcion_respuesta='Me gusta';
            $respuesta->nombre_opcion='A';
            $respuesta->puntos_otorgados=2;
            $respuesta->eliminado=false;
            $respuesta->imagen='uploads/null.png';
            $respuesta->id_pregunta=$model->id;
            $respuesta->save();
            $respuesta->link('idPregunta',$model);

            $respuesta=new RespuestaExamen();
            $respuesta->descripcion_respuesta='Tengo dudas';
            $respuesta->nombre_opcion='B';
            $respuesta->puntos_otorgados=1;
            $respuesta->eliminado=false;
            $respuesta->imagen='uploads/null.png';
            $respuesta->id_pregunta=$model->id;
            $respuesta->save();
            $respuesta->link('idPregunta',$model);

            $respuesta=new RespuestaExamen();
            $respuesta->descripcion_respuesta='No me gusta';
            $respuesta->nombre_opcion='C';
            $respuesta->puntos_otorgados=0;
            $respuesta->eliminado=false;
            $respuesta->imagen='uploads/null.png';
            $respuesta->id_pregunta=$model->id;
            $respuesta->save();
            $respuesta->link('idPregunta',$model);

            $respuesta=new RespuestaExamen();
            $respuesta->descripcion_respuesta='No conosco esa actividad o profesion';
            $respuesta->nombre_opcion='D';
            $respuesta->puntos_otorgados=0;
            $respuesta->eliminado=false;
            $respuesta->imagen='uploads/null.png';
            $respuesta->id_pregunta=$model->id;
            $respuesta->save();
            $respuesta->link('idPregunta',$model);
       /* }else{
                    foreach ($modelRespuestaExamen  as $i => $modelRespuestaExamen) {
                        //cargamos la imagen subida
                        $modelRespuestaExamen->imgfile= UploadedFile::getInstance($modelRespuestaExamen, "[{$i}]imgfile");
                        //verificamos si es nula
                        $this->getImageRespuesta($modelRespuestaExamen);
                        //cargamos la direccion de la imagen
                        //$modelRespuestaExamen->imagen='uploads/'.$imageName;
                        $modelRespuestaExamen->eliminado=0;
                        if (!($modelRespuestaExamen->validate() && $modelRespuestaExamen->save())) {
                            $transaction->rollBack();
                            return false;
                        }
                        $modelRespuestaExamen->link('idPregunta',$model);
                        if($modelRespuestaExamen->imagen!='uploads/null.png'){
                            $modelRespuestaExamen->imgfile->saveAs($modelRespuestaExamen->imagen);
                        }     
                    }*/
        $transaction->commit();
        }  catch (Exception $e){
            $transaction->rollback();
        }
    }
    public function savePregunta(&$model, $modelRespuestaExamen){
        $model->file= UploadedFile::getInstance($model, 'file');
        $this->getImagePregunta($model);       
        // validate all models
        $modelRespuestaExamen = DynamicFormModel::createMultiple(RespuestaExamen::className());
        DynamicFormModel::loadMultiple($modelRespuestaExamen, Yii::$app->request->post());
        $valid = $model->validate() && DynamicFormModel::validateMultiple($modelRespuestaExamen) ;

        if ($valid) {
            $transaction = Yii::$app->db->beginTransaction();
            $model->eliminado=0;
            $flag=$model->save(false);
            if($model->imagen!='uploads/null.png'){
                $model->file->saveAs($model->imagen);
            }
            try {
                if($flag){
                    foreach ($modelRespuestaExamen  as $i => $modelRespuestaExamen) {
                        //cargamos la imagen subida
                        $modelRespuestaExamen->imgfile= UploadedFile::getInstance($modelRespuestaExamen, "[{$i}]imgfile");
                        //verificamos si es nula
                        $this->getImageRespuesta($modelRespuestaExamen);
                        //cargamos la direccion de la imagen
                        //$modelRespuestaExamen->imagen='uploads/'.$imageName;
                        $modelRespuestaExamen->eliminado=0;
                        if (!($modelRespuestaExamen->validate() && $modelRespuestaExamen->save())) {
                            $transaction->rollBack();
                            return false;
                        }
                        $modelRespuestaExamen->link('idPregunta',$model);
                        if($modelRespuestaExamen->imagen!='uploads/null.png'){
                            $modelRespuestaExamen->imgfile->saveAs($modelRespuestaExamen->imagen);
                        }     
                    }
                    $transaction->commit();
                }
            } catch (Exception $e) {
                print_r($e);
                $transaction->rollBack();
                return false;
            }
        }else{
            return false;
        }  
        return true;
    }
    private function getImagePregunta(&$modelP){
        if($modelP->file==null){
            $modelP->imagen='uploads/null.png';
        }
        else{
            $modelP->imagen='uploads/'.$modelP->file->baseName.'.'.$modelP->file->extension;
        }  
    }
    private function getImageRespuesta(&$modelR){
        if($modelR->imgfile==null){
            $modelR->imagen='uploads/null.png';
        }
        else{
            $modelR->imagen='uploads'.$modelR->imgfile->baseName.'.'.$modelR->imgfile->extension;
        }
    }
    public function updatePregunta($model){
        
        $modelRespuestaExamen = $model->respuestaExamens;
        $oldIDs = ArrayHelper::map($modelRespuestaExamen, 'id', 'id');
        $modelRespuestaExamen = DynamicFormModel::createMultiple(RespuestaExamen::classname(), $modelRespuestaExamen);
        DynamicFormModel::loadMultiple($modelRespuestaExamen, Yii::$app->request->post());
        $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelRespuestaExamen, 'id', 'id')));

        if ($model->validate() && DynamicFormModel::validateMultiple($modelRespuestaExamen)) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->file= UploadedFile::getInstance($model, 'file');
                if($model->file!=NULL){
                    $this->getImagePregunta($model);
                }
                if ($model->save(false)) {
                    if($model->file!=NULL){
                        $model->file->saveAs($model->imagen);
                    }
//                    if (! empty($deletedIDs)) {
//                        RespuestaExamen::deleteAll(['id' => $deletedIDs]);
//                    }
                    foreach ($modelRespuestaExamen as $i=> $modelRespuestaExamen) {
                        $modelRespuestaExamen->imgfile=  UploadedFile::getInstance($modelRespuestaExamen, "[{$i}]imgfile");
                        if($modelRespuestaExamen->imgfile!=NULL){
                            $this->getImageRespuesta($modelRespuestaExamen);
                        }
                        if (! ($flag = $modelRespuestaExamen->save(false))) {
                            $transaction->rollBack();
                            return false;
                        }
                        $modelRespuestaExamen->link('idPregunta',$model);
                        if($modelRespuestaExamen->imgfile!=NULL){
                            $modelRespuestaExamen->imgfile->saveAs($modelRespuestaExamen->imagen);
                        }
                    }
                }
                $transaction->commit();
                return true;
            } catch (Exception $e) {
                print_r($e);
                $transaction->rollBack();
                return false;
            }
        }else{
            return false;
        }
            
    }
    public function deletePregunta($id){
        $model=  Pregunta::findOne($id);
        $model->eliminado=1;
        $model->save();
    }
  }
        
