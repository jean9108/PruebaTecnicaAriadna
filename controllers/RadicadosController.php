<?php

namespace app\controllers;

use Yii;
use app\models\Radicados;
use app\models\RadicadosSearch;
use DateTime;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
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
            $model->fecha_registro = date_format($date, 'Y-m-d H:i:s');

            if($model->validate() && $model->save()):
                    $this->setRadicadosTemas($model->id, $model->temas);
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
        $model->temas = $this->getRadicadosTemas($model->id);

         //Validación por Ajax
         if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax ):
            Yii::$app->response->format = Response::FORMAT_JSON;
            return  ActiveForm::validate($model);
        endif;

        if ($model->load(Yii::$app->request->post())) {
            if($model->validate() && $model->save()):
                $this->setRadicadosTemas($model->id,$model->temas);
                return $this->redirect('index');
            else:
                $model->getErrors();
            endif;
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    private function setRadicadosTemas($radicados, $temas){
        //En caso de existir radicados actualiza el estado a inactivo
        $estado =  Yii::$app->db->createCommand()->delete(
                'radicaciones_temas',
                'id_radicacion = :id_radicacion',
                [':id_radicacion' => $radicados]
        );

        $estado->execute();

        foreach($temas as $tema):
            $query = Yii::$app->db->createCommand()->insert('radicaciones_temas',
                [
                    'id_tema' => $tema,
                    'id_radicacion' =>$radicados
                ]
            );
            $query->execute();
        endforeach;
    }

    private function getRadicadosTema($radicado, $tema){
        $query = new Query();
        $query->select(['id_radicacion','id_tema'])
            ->from('radicaciones_temas')
            ->where('id_tema = :id_tema AND id_radicacion = :id_radicacion',
                [
                    ':id_tema' => $tema,
                    ':id_radicacion' => $radicado,
                ]
            );
        $temas = $query->all();
        VarDumper::dump($temas, $depth = 10, $highlight = true);die;
    }

    private function getRadicadosTemas($radicados){
        $query = new Query();
        $query->select(['id_radicacion','id_tema'])
            ->from('radicaciones_temas')
            ->where('estado = :estado AND id_radicacion = :id_radicacion',
                [
                    ':estado' => Yii::$app->params['estadoActivo'],
                    ':id_radicacion' => $radicados,
                ]
            );
        $temas = $query->all();
        return ArrayHelper::map($temas, 'id_tema', 'id_tema');
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
