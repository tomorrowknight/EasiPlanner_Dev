<?php

namespace app\controllers;

use yii\web\Response;

use chief725\libs\ImageUtils;

use Yii;
use app\models\Horizon;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HorizonController implements the CRUD actions for Horizon model.
 */
class ImageController extends Controller{
	/**
	 * Generate an png image
	 * @param string $name
	 * @param integer $id
	 */
	public function actionView($name,$id){
		$response = Yii::$app->getResponse();
		$response->headers->set('Content-Type', 'image/png');
		$response->format = Response::FORMAT_RAW;
		
		$image = ImageUtils::readImage(Yii::getAlias("@webroot/icon/$name.png"));
		if ($id==-1){
			imagefilter($image,IMG_FILTER_BRIGHTNESS,255);
		}elseif($id==0){
			imagefilter($image,IMG_FILTER_BRIGHTNESS,-255);
		}else{
			ImageUtils::changeHue($image, intval($id)*70);
		}
		imagealphablending($image, false);
		imagesavealpha($image, true);
		imagepng($image);
	}
}