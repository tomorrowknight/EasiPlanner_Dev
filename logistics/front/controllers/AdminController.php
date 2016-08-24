<?php

namespace app\controllers;

use app\models\Parcel;

use Yii;
use app\models\Test;
use app\models\TestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TestController implements the CRUD actions for Test model.
 */
class AdminController extends Controller{
	public function actionAddWindow(){
		$parcels = Parcel::find()->all();
		foreach ($parcels as $parcel){
			$month = date("Y-m");
			$day = rand(date("d")-0,date("d")+0);
			$hour = rand(1, 1) * 4 + 4;
			$hour_end = $hour + 16;
			$parcel->identifier = "$parcel->id";
			$parcel->window_start = "$month-$day $hour:00:00";
			$parcel->window_end = "$month-$day $hour_end:00:00";
			$parcel->volume = 0.5;
			$parcel->weight = 0.5;
			$parcel->service_time = 10;
			if(!$parcel->save()){
				print_r($parcel->getErrors());
				exit;
			}
		}
	}
	
	public function actionAddWindow2(){
		$parcels = Parcel::find()->all();
		foreach ($parcels as $parcel){
			$month = date("Y-m");
			$day = rand(date("d")-0,date("d")+0);
			$hour = rand(1, 3) * 4 + 4;
			$hour_end = $hour + 4;
			$parcel->identifier = "$parcel->id";
			$parcel->window_start = "$month-$day $hour:00:00";
			$parcel->window_end = "$month-$day $hour_end:00:00";
			$parcel->volume = 0.5;
			$parcel->weight = 0.5;
			$parcel->service_time = 10;
			if(!$parcel->save()){
				print_r($parcel->getErrors());
				exit;
			}
		}
	}
	
	public function actionAddWindow3(){
		$parcels = Parcel::find()->all();
		foreach ($parcels as $parcel){
			$parcel->volume = 1;
			$parcel->weight = 1;
			$parcel->window_start = date("Y-m-d")." ". date("H:i",strtotime($parcel->window_start));
			$parcel->window_end = date("Y-m-d")." ". date("H:i",strtotime($parcel->window_end));
			$parcel->service_time = 30;
			if(!$parcel->save()){
				print_r($parcel->getErrors());
				exit;
			}
		}
	}
}
