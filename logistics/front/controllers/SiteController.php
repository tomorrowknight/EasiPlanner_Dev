<?php

namespace app\controllers;

use chief725\libs\log\Log;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\Url;

class SiteController extends BaseController {
	public function behaviors() {
		return [
				'access' => [
						'class' => AccessControl::className (),
						'only' => [
								'logout'
						],
						'rules' => [
								[
										'actions' => [
												'logout'
										],
										'allow' => true,
										'roles' => [
												'@'
										]
								]
						]
				],
				'verbs' => [
						'class' => VerbFilter::className (),
						'actions' => [
								'logout' => [
										'post'
								]
						]
				]
		];
	}
	public function actions() {
		return [
				'error' => [
						'class' => 'yii\web\ErrorAction'
				],
				'captcha' => [
						'class' => 'yii\captcha\CaptchaAction',
						'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
				]
		];
	}
	public function actionIndex() {
		if (!Yii::$app->user->isGuest){
			if ($this->currentUser->can("driver")){
				return $this->redirect(['track/index']);
			}
			if ($this->currentUser->can("admin")){
				return $this->redirect(['user/admin']);
			}
			return $this->redirect(['parcel/index']);
		}
		return $this->render ( 'index' );
	}
	public function actionLogin() {
		if (! Yii::$app->user->isGuest) {
			return $this->goHome ();
		}

		$model = new LoginForm ();
		if ($model->load ( Yii::$app->request->post () ) && $model->login ()) {
			return $this->goBack ();
		} else {
			return $this->render ( 'login', [
					'model' => $model
			] );
		}
	}
	public function actionLogout() {
		Yii::$app->user->logout ();
		return $this->goHome ();
	}
	public function actionContact() {
		$model = new ContactForm ();
		if ($model->load ( Yii::$app->request->post () ) && $model->contact ( Yii::$app->params ['adminEmail'] )) {
			Yii::$app->session->setFlash ( 'contactFormSubmitted' );

			return $this->refresh ();
		} else {
			return $this->render ( 'contact', [
					'model' => $model
			] );
		}
	}
	public function actionJs($path) {
		$path = str_replace ( "-", "/", $path );
		header ( 'Content-Type: application/javascript' );
		$content = file_get_contents ( Url::to ( "@webroot/js/$path.js" ) );
		if (YII_ENV == "dev") {
			echo $content;
			exit ();
		} else {
			$content = preg_replace ( "/console.log.*?;/", "", $content );
			$packer = new \Packer ( $content, 62, true, true );
			echo $packer->pack ();
			exit ();
		}
	}
	public function actionAbout() {
		return $this->render ( 'about' );
	}
}
