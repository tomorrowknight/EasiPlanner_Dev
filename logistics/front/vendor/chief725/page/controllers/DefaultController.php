<?php
namespace chief725\page\controllers;

use yii\web\HttpException;
use chief725\page\models\Page;
use yii\web\Controller;

use Yii;

class DefaultController extends Controller
{
	public function isAdmin(){
		return method_exists(Yii::$app->user->identity,"isAdmin") && Yii::$app->user->identity->isAdmin();
	}

	public function actionView($title,$layout=null){
		$this->layout = $layout;
		$content = Page::get($title);
		echo $this->render("view",array("content"=>$content,"title"=>$title,"isAdmin"=>$this->isAdmin()));
	}

	public function actionAdd($title){
		if (!$this->isAdmin()) {
			throw new HttpException("403");
		}
		if(!empty($_POST)){
			Page::set($title, strip_tags($_POST['content']));
			$this->redirect(array("view","title"=>$title));
		}
		$content = Page::get($title);
		echo $this->render('add',array("content"=>$content,"title"=>$title));
	}

}
