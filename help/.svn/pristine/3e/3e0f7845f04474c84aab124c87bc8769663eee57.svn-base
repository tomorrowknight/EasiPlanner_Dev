<?php 
class AdminController extends Controller
{
	public $layout='//layouts/admin';
	public function filters()
	{
		return array(
				'accessControl',
		);
	}
	public function accessRules()
	{
		return array(
				array('allow',
						'users'=>array('@'),
				),
				array('deny',
						'users'=>array('*'),
				),
		);
	}
	public function actionIndex(){
		$this->redirect(array("admin/config"));
	}
	public function actionConfig(){
		if (!empty($_POST)){
			foreach ($_POST as $key=>$value){
				Config::set($key, $value);
			}
		}
		$this->render("config");
	}
	public function actionRefresh(){
		Yii::app()->cache->flush();
		header('Location:' . $_SERVER['HTTP_REFERER']); 
	}
}
?>