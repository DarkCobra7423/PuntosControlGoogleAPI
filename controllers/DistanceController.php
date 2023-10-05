<?php

namespace app\controllers;

use Yii;
use app\models\Coordinatedistance;
use app\models\Distance;
use app\models\Coordinate;
use app\models\DistanceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DistanceController implements the CRUD actions for Distance model.
 */
class DistanceController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Distance models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DistanceSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Distance model.
     * @param int $idDistance Id Distance
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idDistance)
    {
        return $this->render('view', [
            'model' => $this->findModel($idDistance),
        ]);
    }

    /**
     * Creates a new Distance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        // Obtener la solicitud actual utilizando Yii::$app->request.
        $request = Yii::$app->request;

        // Crear una nueva instancia del modelo "Distance".
        $model = new Distance();
        // Comprobar si el valor de "kilometers" en la solicitud POST no es igual a 0.
        if ($request->post('kilometers') != 0) {
            // Si "kilometers" no es igual a 0, asignar el valor de "meters" en la solicitud POST a la propiedad "meters" del modelo.
            $model->meters = $request->post('meters');
            // Asignar el valor de "kilometers" en la solicitud POST a la propiedad "kilometers" del modelo.
            $model->kilometers = $request->post('kilometers');
            // Asignar la propiedad "token" con el valor de "token" en la solicitud POST.
            $model->token = $request->post('token');
            // Intentar guardar el modelo "Distance" en la base de datos.
            if ($model->save()) {
                // Si se guarda correctamente, imprimir el ID del modelo "Distance".
                //echo $model->idDistance;
                // Si se guarda correctamente, se imprime 'Guardado coordinate'.
                // Crear una nueva instancia del modelo "Coordinatedistance".
                $relation = new Coordinatedistance();
                // Asignar valores a las propiedades del modelo "Coordinatedistance".
                $relation->fkCoordinate = Coordinate::find()->where(['=', 'token', $request->post('token')])->one()->idCoordinate;
                // Asignar la propiedad "fkDistance" con el valor del ID del modelo "Coordinate" recién guardado.
                $relation->fkDistance = $model->idDistance;
                // Asignar la propiedad "points" con un mensaje de texto que indica el punto de inicio y destino.
                $relation->points = 'Punto ' . $request->post('point1') . ' a punto ' . $request->post('point2') . ':';
                // Intentar guardar el modelo "Coordinatedistance" en la base de datos.
                print_r($relation);
                if ($relation->save()) {
                    // Si se guarda correctamente, se imprime 'Guardado'.
                    echo 'Guardado';
                } else {
                    // Si hay un error al guardar "Coordinatedistance", se imprime 'Error al guardar datos' y se sale del script.
                    echo 'Error al guardar datos';
                    exit;
                }
            } else {
                // Si hay un error al guardar el modelo "Distance", imprimir "No guardado" y salir del script.
                echo "No guardado";
                exit;
            }
        }
    }

    /**
     * Updates an existing Distance model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idDistance Id Distance
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idDistance)
    {
        $model = $this->findModel($idDistance);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idDistance' => $model->idDistance]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Distance model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idDistance Id Distance
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idDistance)
    {
        $this->findModel($idDistance)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Distance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idDistance Id Distance
     * @return Distance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idDistance)
    {
        if (($model = Distance::findOne(['idDistance' => $idDistance])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
