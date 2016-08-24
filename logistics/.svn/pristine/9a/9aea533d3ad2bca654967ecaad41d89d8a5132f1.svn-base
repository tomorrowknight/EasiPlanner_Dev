<?

namespace app\controllers;

use app\models\Parcel;
use yii\data\ActiveDataProvider;
use Yii;

class ParcelsController extends BaseActiveController {
	public $modelClass = 'app\models\Parcel';
	public function index() {
		$date = empty ( $_GET ['date'] ) ? date ( "Y-m-d" ) : $_GET ['date'];
		$query = Parcel::find ()->with ( [
				'vehicle',
				"vehicle.driver"
		] )->where ( [
				'user_id' => Yii::$app->user->id
		] )->andWhere ( " date(window_start) = :date", [
				':date' => $date
		] )->andWhere ( "failed=0 or lat > 0" );
		return new ActiveDataProvider ( [
				'query' => $query,
				'pagination' => [
						'pageSize' => 2000
				]
		] );
	}
}
