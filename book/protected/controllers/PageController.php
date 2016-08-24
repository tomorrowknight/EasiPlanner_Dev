<?php

class PageController extends Controller
{
	public function actionView($title)
	{
		$content = Config::get($title);
		if(empty($content)){
			if (Yii::app()->user->isGuest) {
				throw new CHttpException("404","Page Not Found");
			}else{
				$this->redirect(array("page/add","title"=>$title));
			}
		}
		$this->render("view",array("content"=>$content,"title"=>$title));
	}
	public function actionAdd($title){
		if(!empty($_POST)){
			Config::set($title, $_POST['content']);
			$this->redirect(array("page/view","title"=>$title));
			return;
		}
		$content = Config::get($title);
		$this->render('add',array("content"=>$content,"title"=>$title));
	}
}