<?php 
class ModelController extends Controller
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

	public function actionIndex($modelClass,$parent_id=null){
		$classModel = $modelClass::model();
		$attrs = $classModel->getSafeAttributeNames();
		#echo json_encode($attrs);exit;
		if (!empty($_POST[$modelClass])){
			foreach ($_POST[$modelClass] as $modelArr){
				$model = $modelClass::model()->findByPk($modelArr['id']);
				$model->attributes = $modelArr;
				$model->save();
			}
		}

		$criteria = new CDbCriteria;
		$criteria->compare("domain",DOMAIN);
		if ($classModel->hasAttribute("seq")){
			$criteria->order = "seq asc";
		}
		if ($classModel->hasAttribute("hits")){
			$criteria->order = "hits desc";
		}
		if ($parent_id!=null){
			$criteria->condition = "parent_id=".intval($parent_id);
		}
		$models = $classModel->findAll($criteria);
		$this->render("index",array(
				'modelClass'=>$modelClass,
				"attrs"=>$attrs,
				"models"=>$models,
				"parent_id"=>$parent_id,
				"has_parent"=>$classModel->hasAttribute("parent_id")
		));
	}

	public function actionAdd($modelClass,$parent_id){
		$model = new $modelClass;
		$model->domain = DOMAIN;
		if (!empty($parent_id)){
			$model->parent_id = $parent_id;
		}
		if(!$model->save()){
			echo json_encode($model->getErrors());
			exit;
		}
		$this->redirect(array("model/index","modelClass"=>$modelClass,"parent_id"=>$parent_id));
	}

	public function actionRemove($modelClass,$id,$parent_id){
		$modelClass::model()->deleteByPk($id);
		$this->redirect(array("model/index","modelClass"=>$modelClass,"parent_id"=>$parent_id));
	}
	public function getSize($models, $attr){
		$size =3;
		foreach ($models as $model){
			$size = max($size,strlen($model->$attr));
		}
		return $size+4;
	}
}
?>