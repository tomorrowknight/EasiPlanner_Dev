<?
use yii\widgets\Breadcrumbs;
use chief725\lookup\Module;
use yii\helpers\Html;
?>
<? 
function htmlViewLink($model,$modelClass,$has_parent){
	if ($has_parent) {
		echo Html::a ( "View", ["default/index","modelClass" => $modelClass,"parent_id" => $model->id], ["class" => "btn btn-primary"]);
	} else {
		echo "#" . $model->id;
	}
}

function htmlInput($model,$index,$attr,$models){
	$isTextarea = false;
	if ($model->hasAttribute("title") && preg_match ( "/_text$/", $model->title) && $attr =="content"){
		$isTextarea = true;
	}
	if (preg_match ( "/_text$/", $attr )){
		$isTextarea = true;
	}
	if ($isTextarea) {
		echo Html::activeTextarea ( $model, "[$index]$attr", array (
				"class" => 'form-control',
				'rows' => count ( explode ( "\n", $model->$attr ) )
		) );
	} else {
		echo Html::activeTextInput ( $model, "[$index]$attr", array (
				"size" => Module::getSize ( $models, $attr ),
				"class" => 'form-control'
		) );
	}
}

function htmlDelLink($model,$modelClass,$parent_id){
	echo Html::a("Del",array("default/remove","modelClass"=>$modelClass,"id"=>$model->id,"parent_id"=>$parent_id),array("class"=>"btn btn-danger"));
}
?>

<h2>
	<?=$modelClass?>
</h2>


<form method='post'>
	<div class='btn-group' style='margin-bottom: 10px;'>
		<? echo Html::a("Add",array("default/add","modelClass"=>$modelClass,"parent_id"=>$parent_id),array("class"=>"btn btn-primary"))?>
		<?
		if ($parent_id != null) {
			$parentModel = $modelClass::findOne( $parent_id );
			if (! empty ( $parentModel )) {
				echo Html::a("Back", ["default/index","modelClass" => $modelClass,"parent_id" => $parentModel->parent_id],["class" => "btn btn-primary"]);
			}
		}
		?>
		<input type='submit' value='Save' class='btn btn-primary'>
	</div>

	<?php if(!isset($modelClass::$seperate)):?>
	<table class='table table-bordered table-striped'>
		<tr>
			<td></td>
			<? foreach ($attrs as $attr):?>
			<th><? echo $attr?>
			</th>
			<? endforeach;?>
			<td></td>
		</tr>
		<? foreach ($models as $index=>$model):?>
		<tr>
			<? echo Html::activeHiddenInput($model,"[$index]id")?>
			<td><? htmlViewLink($model,$modelClass,$has_parent)?></td>

			<? foreach ($attrs as $attr):?>
			<td><?htmlInput($model,$index,$attr,$models)?></td>
			<? endforeach;?>
			
			<td><?htmlDelLink($model,$modelClass,$parent_id)?></td>
		</tr>
		<? endforeach;?>
	</table>
	
	<?php else:?>

	<? foreach ($models as $index=>$model):?>
	<table class='table table-striped table-bordered'>
		<? echo Html::activeHiddenInput($model,"[$index]id")?>
		<tr>
			<td><?htmlViewLink($model,$modelClass,$has_parent)?></td>
			<td><?htmlDelLink($model,$modelClass,$parent_id)?></td>
		</tr>
		<?foreach ($attrs as $attr):?>
		<tr>
			<td><?=$attr?></td>
			<td><?htmlInput($model,$index,$attr,$models)?></td>
		</tr>
		<?php endforeach;?>
	</table>
	<?php endforeach;?>
	
	
	<?php endif;?>
</form>
