<?php

namespace app\controllers;

use Yii;
use app\models\InscripcionExamen;
use app\models\InscripcionExamenSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Persona;
use app\models\DynamicFormModel;
use app\negocio\InscripcionNegocio;
use  \yii\helpers\Json;
use app\models\Llave;
use app\models\Examen;
use app\models\ModelInscripcion;
/**
 * InscripcionExamenController implements the CRUD actions for InscripcionExamen model.
 */
class InscripcionExamenController extends Controller
{
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
     * Lists all InscripcionExamen models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InscripcionExamenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InscripcionExamen model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $persona=  Persona::findOne($id);
        $examenes=  InscripcionExamen::findAll(['id_alumno'=>$persona->id]);
        return $this->render('view', [
            'persona' => $persona,
            'examenes'=>$examenes
        ]);
    }
    public function actionInscripcionLlave(){
        $l=new Llave();
        $model=new ModelInscripcion();
        $negocio=new InscripcionNegocio();
        if($model->load(Yii::$app->request->post())
                && $negocio->inscripcionPorLlave($model)){
                    $this->redirect(['aplicar-examen/index']);
        }
        return $this->render('inscripcion-llave',['model'=>$model]);
    }
    /**
     * Creates a new InscripcionExamen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelInscripcionExamen = [new InscripcionExamen()];
        $modelPersona=new Persona();
        $InscripcionNegocio=new InscripcionNegocio;

        if ($modelPersona->load(Yii::$app->request->post())) {
            $modelPersona->ciudad="Santa Cruz";
            $valid = $modelPersona->validate();
            if($valid){
                $InscripcionNegocio->RegistrarInscripcion($modelPersona,
                        $modelInscripcionExamen);
            }else{
                 return $this->render('create', [
                'modelsInscripcion' => $modelInscripcionExamen,
                'modelPersona'=>$modelPersona
                ]);
            }
            return $this->redirect(['view', 'id' => $modelPersona->id]);
        } else {
            return $this->render('create', [
                'modelsInscripcion' => $modelInscripcionExamen,
                'modelPersona'=>$modelPersona
            ]);
        }
    }

    /**
     * Updates an existing InscripcionExamen model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionGetPersonaByCi($ci){
        $persona=Persona::find()->where(['ci'=>$ci,'eliminado'=>0])->one();
        echo Json::encode($persona);
   
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing InscripcionExamen model.
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
     * Finds the InscripcionExamen model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InscripcionExamen the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InscripcionExamen::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
