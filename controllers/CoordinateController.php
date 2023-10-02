<?php

namespace app\controllers;

use Yii;
use app\models\Coordinatedistance;
use app\models\Coordinate;
use app\models\CoordinateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CoordinateController implements the CRUD actions for Coordinate model.
 */
class CoordinateController extends Controller
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
     * Lists all Coordinate models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CoordinateSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Coordinate model.
     * @param int $idCoordinate Id Coordinate
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idCoordinate)
    {
        return $this->render('view', [
            'model' => $this->findModel($idCoordinate),
        ]);
    }

    /**
     * Creates a new Coordinate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        // Obtener la solicitud actual utilizando Yii::$app->request.
        $request = Yii::$app->request;
        // Crear una nueva instancia del modelo "Coordinate".
        $model = new Coordinate();
        // Asignar valores a las propiedades del modelo "Coordinate" a partir de los datos de la solicitud POST.
        // Asignar la propiedad "latitude" con el valor de "latitude" en la solicitud POST.
        $model->latitude = $request->post('latitude');
        // Asignar la propiedad "longitude" con el valor de "longitude" en la solicitud POST.
        $model->longitude = $request->post('longitude');
        // Asignar la propiedad "time" con la fecha y hora actual en formato 'Y-m-d H:i:s'.
        $model->time = date('Y-m-d H:i:s');
        // Asignar la propiedad "token" con el valor de "token" en la solicitud POST.
        $model->token = $request->post('token');
        // Intentar guardar el modelo "Coordinate" en la base de datos.
        if ($model->save()) {
            // Si se guarda correctamente, se imprime 'Guardado coordinate'.
            // Crear una nueva instancia del modelo "Coordinatedistance".
            $relation = new Coordinatedistance();
            // Asignar valores a las propiedades del modelo "Coordinatedistance".
            // Asignar la propiedad "fkCoordinate" con el valor de "idDistance" en la solicitud POST.
            $relation->fkCoordinate = $request->post('idDistance');
            // Asignar la propiedad "fkDistance" con el valor del ID del modelo "Coordinate" recién guardado.
            $relation->fkDistance = $model->idCoordinate;
            // Asignar la propiedad "points" con un mensaje de texto que indica el punto de inicio y destino.
            $relation->points = 'Punto ' . $request->post('point1') . ' a punto ' . $request->post('point2') . ':';
            // Intentar guardar el modelo "Coordinatedistance" en la base de datos.
            if ($relation->save()) {
                // Si se guarda correctamente, se imprime 'Guardado'.
                echo 'Guardado';
            } else {
                // Si hay un error al guardar "Coordinatedistance", se imprime 'Error al guardar datos' y se sale del script.
                echo 'Error al guardar datos';
                exit;
            }
        } else {
            // Si hay un error al guardar "Coordinate", se imprime 'Error al guardar datos' y se sale del script.
            echo 'Error al guardar datos';
            exit;
        }
    }

    public function actionShow()
    {
        //print_r(Yii::$app->request->post('token'));
        //die();
        //$coordinates = Coordinate::find()->where(["token" => Yii::$app->request->csrfToken])->orderBy('time')->all();
        $coordinates = Coordinate::find()->where(["token" => Yii::$app->request->post('token')])->all();
        $num = 1;
        foreach ($coordinates as $coordinate) :
            echo '<tr>
                <th scope="row">' . $num . '</th>
                <td>' . $coordinate->latitude . '</td>
                <td>' . $coordinate->longitude . '</td>
                </tr>';
            $num++;
        endforeach;

        exit;
    }
    /**
     * Updates an existing Coordinate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idCoordinate Id Coordinate
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idCoordinate)
    {
        $model = $this->findModel($idCoordinate);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idCoordinate' => $model->idCoordinate]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Coordinate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idCoordinate Id Coordinate
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idCoordinate)
    {
        $this->findModel($idCoordinate)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Coordinate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idCoordinate Id Coordinate
     * @return Coordinate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idCoordinate)
    {
        if (($model = Coordinate::findOne(['idCoordinate' => $idCoordinate])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
