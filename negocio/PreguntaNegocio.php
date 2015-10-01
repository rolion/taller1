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
/**
 * Description of PreguntaNegocio
 *
 * @author root
 */
class PreguntaNegocio {
    
    public function savePregunta(&$model, $modelRespuestaExamen){
        $model->file= UploadedFile::getInstance($model, 'file');
        if($model->file==null)
            $imageName='null.png';
        else
            $imageName=$model->file->baseName.'.'.$model->file->extension;
                    // validate all models
        $modelRespuestaExamen = DynamicFormModel::createMultiple(RespuestaExamen::className());
        DynamicFormModel::loadMultiple($modelRespuestaExamen, Yii::$app->request->post());
        $valid = $model->validate();
        $valid = DynamicFormModel::validateMultiple($modelRespuestaExamen) && $valid;
        // ajax validation
//        if (Yii::$app->request->isAjax) {
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            return ArrayHelper::merge(
//                ActiveForm::validateMultiple($modelRespuestaExamen),
//                ActiveForm::validate($model)
//            );
//        }

        if ($valid) {
            $model->imagen='uploads/'.$imageName;
            $flag=$model->save(false);
            //$modelRespuestaExamen->save();
            if($imageName!='null.png')
                $model->file->saveAs('uploads/'.$imageName);
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if($flag){
                    foreach ($modelRespuestaExamen as $modelRespuestaExamen) {
                        $modelRespuestaExamen->id_pregunta = $model->id;
                        //cargamos la imagen subida
                        $modelRespuestaExamen->file= UploadedFile::getInstance($modelRespuestaExamen, 'file');
                        //verificamos si es nula
                        if($modelRespuestaExamen->file==null)
                            $imageName='null.png';
                        else
                            $imageName=$model->file->baseName.'.'.$model->file->extension;
                        //cargamos la direccion de la imagen
                        $modelRespuestaExamen->imagen='uploads/'.$imageName;
                        if (! ($flag = $modelRespuestaExamen->save(false))) {
                            $transaction->rollBack();
                            break;
                        }
                    }
                    //guardamos la imagen
                     if($imageName!='null.png')
                     $model->file->saveAs('uploads/'.$imageName);
                     $transaction->commit();
                     
      
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                return false;
            }
        }else
            return false;
        return true;
    }
}
        
