<?php

namespace chief725\lookup\controllers;

use yii\web\HttpException;

use yii\filters\AccessControl;
use Yii;
use app\models\Lookup;
use chief725\libs\Log;
use yii\web\Controller;

class DefaultController extends Controller
{
	public $enableCsrfValidation = false;

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

	public function beforeAction($action){
		if (method_exists(Yii::$app->user->identity,"isAdmin") && Yii::$app->user->identity->isAdmin()){
			return parent::beforeAction($action);
		}
		echo "Are you admin?";
		exit;
	}

	public function actionIndex($modelClass="app\\models\\Lookup",$parent_id=null,$layout=null)
	{
		$this->layout = $layout;
		$classModel = new $modelClass;
		$attrs = $classModel->activeAttributes();

		$classShortName = (new \ReflectionClass($modelClass))->getShortName();
		if (!empty($_POST[$classShortName])){
			foreach ($_POST[$classShortName] as $modelArr){
				$model = $modelClass::findOne($modelArr['id']);

				$model->setAttributes($modelArr);

				//print_r($model);exit;
				
				if(!$model->save(false)){
					print_r(json_encode($model->getErrors()));
					exit;
				}
			}
		}

		$query = $classModel->find();

		if ($classModel->hasAttribute("seq")){
			$query->orderBy("seq asc, id asc");
		}elseif ($classModel->hasAttribute("hits")){
			$query->orderBy("hits desc, id asc");
		}else{
			$query->orderBy("id asc");
		}
		if ($classModel->hasAttribute("parent_id")){
			$query->where("parent_id=".intval($parent_id));
		}
		$models = $query->all();

		echo $this->render("index",array(
				'modelClass'=>$modelClass,
				"attrs"=>$attrs,
				"models"=>$models,
				"parent_id"=>$parent_id,
				"has_parent"=>$classModel->hasAttribute("parent_id")
		));
	}

	public function actionAdd($modelClass,$parent_id=0){
		$model = new $modelClass;
		if ($model->hasAttribute("parent_id")){
			$model->parent_id = $parent_id;
		}
		if(!$model->save(false)){
			echo json_encode($model->getErrors());
			exit;
		}
		$this->redirect(array("default/index","modelClass"=>$modelClass,"parent_id"=>$parent_id));
	}


	public function actionRemove($modelClass,$id,$parent_id=null){
		$model = $modelClass::findOne($id);
		if ($model->hasAttribute("parent_id") && $model::find()->where(["parent_id" => $model->id])->count() > 0)
			throw new HttpException("500","Children should be removed first.");
		$model->delete();
		$this->redirect(array("default/index","modelClass"=>$modelClass,"parent_id"=>$parent_id));
	}
}
