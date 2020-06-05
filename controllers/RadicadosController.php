<?php

namespace app\controllers;

use Yii;
use app\models\Radicados;
use app\models\RadicadosSearch;
use DateTime;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
//Librerias para validacion por Ajax
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * RadicadosController implements the CRUD actions for Radicados model.
 */
class RadicadosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' =>[
                ['actions' => ['index', 'create', 'update','delete'],
                    'allow' => true,
                    'roles' => ['@']
                ]
            ],
        ];

        return $behaviors;
    }

    /**
     * Lists all Radicados models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RadicadosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new Radicados model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        date_default_timezone_set('America/Bogota');
        $date = new \DateTime('now');
        $model = new Radicados();
        $msg = '';
        $model->user_id =Yii::$app->user->id;

        //Validación por Ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax ):
            Yii::$app->response->format = Response::FORMAT_JSON;
            return  ActiveForm::validate($model);
        endif;

        if($model->load(Yii::$app->request->post())):
            $temas = implode(',',$model->temas);
            $model->temas = $temas;
            $model->fecha_registro = date_format($date, 'Y-m-d H:i:s');

            if($model->validate() && $model->save()):
                    return $this->redirect('index');
            else:
               $model->getErrors();
            endif;
        endif;
        return $this->render('create', [
            'model' => $model,
            'msg' => $msg
        ]);
    }

    /**
     * Updates an existing Radicados model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $temas = explode(',', $model->temas);
        $model->temas = $temas;

         //Validación por Ajax
         if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax ):
            Yii::$app->response->format = Response::FORMAT_JSON;
            return  ActiveForm::validate($model);
        endif;

        if ($model->load(Yii::$app->request->post())) {
            $temas = implode(',',$model->temas);
            $model->temas = $temas;
            if($model->validate() && $model->save()):
                return $this->redirect('index');
            else:
                $model->getErrors();
            endif;
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Radicados model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Radicados model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Radicados the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Radicados::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
