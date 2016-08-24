<?
use yii\widgets\ActiveForm;

use yii\helpers\Html;

?>

<? ActiveForm::begin();?>
	<h2>
		<?php echo $title?>
	</h2>
	<div class='form-group'>
		<?=Html::tag("textarea",strip_tags($content),['class'=>'form-control','style'=>'height:600px','name'=>'content'])?>
		<br /> <input type="submit" value="完成" class="btn btn-primary">
	</div>
<?php ActiveForm::end() ?>