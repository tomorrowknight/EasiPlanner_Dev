<?php

namespace app\controllers;

use app\models\Vehicle;

use yii\helpers\ArrayHelper;

use app\models\Parcel;

use yii\filters\AccessControl;

use Yii;
use app\models\Driver;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DriverController implements the CRUD actions for Driver model.
 */
class MapController extends Controller
{
	public function behaviors()
	{
		return [
		'access' => array(
				'class' => AccessControl::className(),
				'rules' =>  array(
						array(
								'allow' => true,
								'roles' => ['@'],
						),
				),
		),
		];
	}

	/**
	 * Lists all Driver models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$this->layout = "base";
		return $this->render('index');
	}

	public function actionApiParcels($date = null){
		if(empty($date)) $date = date("Y-m-d");
		$query = Parcel::find()->with(['vehicle',"vehicle.driver"])
		->where(['user_id'=>Yii::$app->user->id])
		->andWhere(" date(window_start) = :date",[':date'=>$date]);
		$models = $query->asArray()->all();
		Yii::$app->response->format = 'json';
		return $models;
	}

	public function actionApiVehicles(){
		$models = Vehicle::find()->with("driver")->where(['user_id'=>Yii::$app->user->id])->asArray()->all();
		foreach($models as $index=>$model){
			$vehicle = Vehicle::findOne($model['id']);
			$models[$index]['capacityLeft'] = $vehicle->getCapacityLeft();
		}
		Yii::$app->response->format = 'json';
		return $models;
	}

	public function actionApiProfile(){
		Yii::$app->response->format = 'json';
		return Yii::$app->user->identity->profile;
	}

	public function actionAssignParcels(){
		$vehicle = Vehicle::findOne(Yii::$app->request->post("vehicle_id"));
		$driver = Vehicle::findOne(Yii::$app->request->get("driver_id"));
		$parcels = Parcel::findAll(explode(",", Yii::$app->request->post("parcel_ids")));
		foreach ($parcels as $parcel){
			$parcel->vehicle_id = empty($vehicle)?0: $vehicle->id;
			$parcel->driver_id = empty($vehicle)?0: $vehicle->driver_id;
			Yii::app()->user->setFlash('success',$parcel->driver_id);
			Utils::print_d($parcel->driver_id);
			$parcel->save(false);
		}
		//$this->redirect(["map/index"]);
	}
}
