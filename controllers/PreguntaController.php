<?php

namespace app\controllers;

use Yii;
use app\models\Pregunta;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\RespuestaExamen;
use yii\web\UploadedFile;
use app\models\DynamicFormModel;
use yii\helpers\ArrayHelper;
use app\negocio\PreguntaNegocio;

/**
 * PreguntaController implements the CRUD actions for Pregunta model.
 */
class PreguntaController extends Controller
{
    private $negocio;
    public function init() {
        parent::init();
        $this->negocio=new PreguntaNegocio();
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Pregunta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Pregunta::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pregunta model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
         $dataProvider=new ActiveDataProvider([
                'query' => RespuestaExamen::find()->where(['id_pregunta'=>$id])->orderBy('id'),]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider'=>$dataProvider
        ]);
    }

    /**
     * Creates a new Pregunta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pregunta();
        $modelRespuestaExamen=[new RespuestaExamen];

        if ($model->load(Yii::$app->request->post()) &&
        $this->negocio->savePregunta($model, $modelRespuestaExamen) ) {
            $dataProvider=new ActiveDataProvider([
                        'query' => RespuestaExamen::find()->where(['id_pregunta'=>$model->id])->orderBy('id'),]);
          return $this->redirect(['view', 'id' => $model->id,'dataProvider'=>$dataProvider]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelRespuestaExamen'=>(empty($modelsRespuestaExamen)) ?
                [new RespuestaExamen] : $modelsRespuestaExamen,
            ]);
        }
    }

    /**
     * Updates an existing Pregunta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
        $model = $this->findModel($id);
        $modelRespuestaExamen = $model->respuestaExamens;

        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelRespuestaExamen, 'id', 'id');
            $modelRespuestaExamen = DynamicFormModel::createMultiple(RespuestaExamen::classname(), $modelRespuestaExamen);
            DynamicFormModel::loadMultiple($modelRespuestaExamen, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelRespuestaExamen, 'id', 'id')));
            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelRespuestaExamen),
                    ActiveForm::validate($model)
                );
            }
            // validate all models
            $valid = $model->validate();
            $valid = DynamicFormModel::validateMultiple($modelRespuestaExamen) && $valid;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            RespuestaExamen::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelRespuestaExamen as $modelRespuestaExamen) {
                            $modelRespuestaExamen->id_pregunta = $model->id;
                            if (! ($flag = $modelRespuestaExamen->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
            'modelRespuestaExamen' => (empty($modelRespuestaExamen)) ? [new RespuestaExamen] : $modelRespuestaExamen
        ]);
    }
    

    /**
     * Deletes an existing Pregunta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pregunta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pregunta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pregunta::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
