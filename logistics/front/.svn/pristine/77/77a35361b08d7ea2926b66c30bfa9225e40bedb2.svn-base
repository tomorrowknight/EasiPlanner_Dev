<?php

namespace app\controllers;

use Yii;
use app\models\Vehicle;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VehicleController implements the CRUD actions for Vehicle model.
 */
class VehicleController extends Controller {
	public function behaviors() {
		return [ 
				'verbs' => [ 
						'class' => VerbFilter::className (),
						'actions' => [ 
								'delete' => [ 
										'post' 
								],
								'batch-update' => [ 
										'post' 
								] 
						] 
				] 
		];
	}
	
	/**
	 * Lists all Vehicle models.
	 *
	 * @return mixed
	 */
	public function actionIndex() {
		$dataProvider = new ActiveDataProvider ( [ 
				'query' => Vehicle::find ()->where ( [ 
						'vehicle.user_id' => Yii::$app->user->id 
				] )->joinWith ( 'driver' ) 
		] );
		
		return $this->render ( 'index', [ 
				'dataProvider' => $dataProvider 
		] );
	}
	
	/**
	 * Displays a single Vehicle model.
	 *
	 * @param integer $id        	
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render ( 'view', [ 
				'model' => $this->findModel ( $id ) 
		] );
	}
	public function actionBatchUpdate() {
		foreach ( Yii::$app->user->identity->vehicles as $vehicle ) {
			$vehicle->capacity_volume = $_POST ['capacity_volume'];
			$vehicle->capacity_weight = $_POST ['capacity_weight'];
			$vehicle->save ();
		}
		$this->redirect ( [ 
				'index' 
		] );
	}
	
	/**
	 * Creates a new Vehicle model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new Vehicle ();
		
		if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
			return $this->redirect ( [ 
					'view',
					'id' => $model->id 
			] );
		} else {
			return $this->render ( 'create', [ 
					'model' => $model 
			] );
		}
	}
	
	/**
	 * Updates an existing Vehicle model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id        	
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel ( $id );
		
		if ($model->load ( Yii::$app->request->post () ) && $model->save ()) {
			return $this->redirect ( [ 
					'view',
					'id' => $model->id 
			] );
		} else {
			return $this->render ( 'update', [ 
					'model' => $model 
			] );
		}
	}
	
	/**
	 * Deletes an existing Vehicle model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param integer $id        	
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel ( $id )->delete ();
		
		return $this->redirect ( [ 
				'index' 
		] );
	}
	public function actionData() {
		Yii::$app->response->format = 'json';
		// return $parcels;
		return Yii::$app->user->identity->vehicles;
	}
	public function actionParcels($id, $date = null) {
		if (empty ( $date )) {
			$date = date ( "Y-m-d" );
		}
		$model = $this->findModel ( $id );
		$dataProvider = new ActiveDataProvider ( [ 
				'query' => $model->getParcels ()->where(["DATE(window_start)"=>$date])->orderBy ( "route,seq" ) 
		] );
		
		return $this->render ( 'parcels', [ 
				'dataProvider' => $dataProvider,
				'model' => $model,
				'date' => $date 
		] );
	}
	
	/**
	 * Finds the Vehicle model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id        	
	 * @return Vehicle the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Vehicle::findOne ( $id )) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException ( 'The requested page does not exist.' );
		}
	}
}
