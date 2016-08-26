<?

namespace app\controllers;

use yii\data\ActiveDataProvider;
use app\models\Parcel;
use Yii;
use yii\rest\ActiveController;

class VehiclesController extends BaseActiveController {
	public $modelClass = 'app\models\Vehicle';
	public function index() {
		return new ActiveDataProvider ( [
				'query' => Yii::$app->user->identity->getActiveVehicles (),
				'pagination' => [
						'pageSize' => 2000
				]
		] );
	}
}