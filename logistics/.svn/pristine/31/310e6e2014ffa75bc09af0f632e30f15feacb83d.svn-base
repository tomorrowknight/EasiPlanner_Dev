<?

namespace app\controllers;

use yii\data\ActiveDataProvider;

use app\models\Parcel;
use Yii;
use yii\rest\ActiveController;

class DriversController extends BaseActiveController
{
	public $modelClass = 'app\models\Driver';

	public function index()
	{
		return new ActiveDataProvider([
				'query' => Yii::$app->user->identity->getDrivers(),
				'pagination' => [
				'pageSize' => 2000,
				],
				]);
	}
}