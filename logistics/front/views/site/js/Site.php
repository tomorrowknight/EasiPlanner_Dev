<?
use yii\helpers\Url;
?>

function Site(){
	this.urlTo = function(relativeUrl){
		return "<?=Url::to("/")?>"+relativeUrl;
	}
}