<?

namespace app\controllers;

use yii\web\Response;

use yii\filters\ContentNegotiator;

use yii\data\ActiveDataProvider;

use app\models\Parcel;
use Yii;
use yii\rest\ActiveController;
class BaseActiveController extends ActiveController
{
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['bootstrap'] = array(
				'class' => ContentNegotiator::className(),
				'formats' => ['application/json' => Response::FORMAT_JSON],
		);
		return $behaviors;
	}
	public function actions()
	{
		$actions = parent::actions();
		$actions['index']['prepareDataProvider'] = [$this, 'index'];
		$this->blockActions($actions);
		return $actions;
	}
	
	public function index(){
		$modelClass =$this->modelClass; 
		return new ActiveDataProvider([
				'query' => $modelClass::find(),
				'pagination' => [
				'pageSize' => 2000,
				],
				]);
	}
	
	protected function blockActions(&$actions){
		
	}
}