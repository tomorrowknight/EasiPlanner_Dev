<h3>
	<?=$modelClass?>
	Management
</h3>

<? echo CHtml::link("Add",array("model/add","modelClass"=>$modelClass,"parent_id"=>$parent_id),array("class"=>"btn btn-primary"))?>
<? if ($parent_id != null){
	$parentModel = $modelClass::model()->findByPk($parent_id);
	if (!empty($parentModel)){
		echo CHtml::link("Back",array("model/index","modelClass"=>$modelClass,"parent_id"=>$parentModel->parent_id),array("class"=>"btn btn-primary"));
	}
}?>
<form method='post'>
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
			<? echo CHtml::activeHiddenfield($model,"[$index]id")?>

			<td><? if ($has_parent) {
				echo CHtml::link("View",array("model/index","modelClass"=>$modelClass,"parent_id"=>$model->id),array("class"=>"btn btn-primary"));
			}else{
				echo "#".$model->id;
			}
			?>
			</td>

			<? foreach ($attrs as $attr):?>
			<td><? echo CHtml::activeTextfield($model,"[$index]$attr",array("size"=>$this->getSize($models,$attr)))?>
			</td>
			<? endforeach;?>
			<td><? echo CHtml::link("Del",array("model/remove","modelClass"=>$modelClass,"id"=>$model->id,"parent_id"=>$parent_id),array("class"=>"btn btn-danger"))?>
			</td>
		</tr>
		<? endforeach;?>
	</table>
	<input type='submit' value='Submit' class='btn btn-primary'>
</form>
