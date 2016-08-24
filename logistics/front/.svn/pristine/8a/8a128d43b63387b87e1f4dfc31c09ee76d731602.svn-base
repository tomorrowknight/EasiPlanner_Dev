<?php

namespace chief725\controllers;


use chief725\libs\Utils;

use chief725\models\User;
use chief725\models\Image;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
	            'class' => 'yii\authclient\AuthAction',
	            'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }

    public function successCallback($client)
    {
    	$user = User::createOrFindUser($client);
    	Yii::$app->user->login($user, 3600*24*30);
    	if ($user->is(User::FLAG_ADMIN)){
    		Yii::$app->session->set("role",'admin');
    	}
    	$this->afterLogin();
    }

    public function afterLogin(){
    	$this->redirect(Yii::$app->user->getReturnUrl());
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
       $this->redirect(["auth","authclient"=>'facebook']);
    }

    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionImage($class,$id,$width,$height,$resizeType=Image::RESIZE_NORMAL,$imageType="jpeg"){
    	header("Content-Type:image/$imageType");
    	Utils::header_expire(3600*240);
    	$class = str_replace(".", "\\", $class);
    	$image = $class::findOne($id);
    	if (!empty($image) && $image->isThere()){
    		imagejpeg($image->cut($width, $height,$resizeType));
    	}else{
    		echo file_get_contents($class::getImageDefaultUrl());
    	}
    	exit;
    }

}
