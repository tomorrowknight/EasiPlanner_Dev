<?php

namespace app\controllers;

use chief725\libs\ImageUtils;

use yii\web\Response;

use app\models\User;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class BaseController extends Controller
{
	public $currentUser;

	public function behaviors()
	{
		$behaviors =  array(
				'access' => array(
						'class' => AccessControl::className(),
						'rules' => array(
								array(
										'allow' => true,
										'roles' => ['@'],
								),
						),
				),
		);
		return $behaviors;
	}

	public function init(){
		if (!Yii::$app->user->isGuest){
			$this->currentUser = Yii::$app->user->identity;
		}
	}
}
