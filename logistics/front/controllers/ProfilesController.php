<?

namespace app\controllers;

use yii\data\ActiveDataProvider;

use app\models\Parcel;
use Yii;
use yii\rest\ActiveController;

class ProfilesController extends BaseActiveController
{
	public $modelClass = 'app\models\MyProfile';
	protected function blockActions(&$actions){
		unset($actions['update'],$actions['index']);
	}
	public function actionMyProfile(){
		return Yii::$app->user->identity->profile;
	}
}