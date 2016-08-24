<?

namespace app\controllers;

use Yii;
use app\models\Driver;
use app\models\Parcel;
use app\models\Image;
use yii\web\UploadedFile;
use yii\web\Response;

class TrackController extends BaseController {
	public function actionIndex($date = null) {
		if (empty ( $date )) {
			$date = date ( "Y-m-d" );
		}
		$driver = Driver::findOne ( Yii::$app->user->id );
		echo $this->render ( "index", [
				'driver' => $driver,
				'vehicle' => $driver->vehicle,
				'date' => $date
		] );
	}
	public function actionView($id) {
		$model = Parcel::findOne ( $id );
		if (! empty ( $_POST )) {
			$uploadedFiles = UploadedFile::getInstancesByName ( 'parcelImages' );
			if (! empty ( $uploadedFiles )) {
				foreach ( $uploadedFiles as $index => $uploadedFile ) {
					if (! Image::createImage ( $id )->upload ( $uploadedFile, 800, 800 )) {
						Yii::$app->session->setFlash ( "danger", "Failed to upload." );
					}
				}
			}
			if (! empty ( $_POST ['signature'] )) {
				Yii::$app->response->format = Response::FORMAT_JSON;
				$model->signature = $_POST ['signature'];
				return [
						'status' => $model->save () ? 'yes' : "no"
				];
			}
		}
		return $this->render ( "view", [
				'model' => $model
		] );
	}
	public function actionUpdateStatus($id, $status) {
		$model = Parcel::findOne ( $id );
		$model->status = $status;
		$model->save ();
		return $this->redirect ( [
				'view',
				'id' => $id
		] );
	}
	public function actionMap($id) {
		$model = Parcel::findOne ( $id );
		return $this->render ( "map", [
				'model' => $model
		] );
	}
}