<? 
namespace app\controllers;

use yii\rest\ActiveController;

class LocationController extends ActiveController
{
	public $modelClass = 'app\models\Location';
	public $serializer = [
	'class' => 'yii\rest\Serializer',
	'collectionEnvelope' => 'locations',
	];
}
?>