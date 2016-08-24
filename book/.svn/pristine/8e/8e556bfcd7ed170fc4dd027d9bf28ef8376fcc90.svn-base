<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
        selector: "textarea",
        plugins: [
                "advlist autolink link image lists charmap hr",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media",
                "table textcolor paste fullpage textcolor"
        ],

        toolbar1: "code | bold italic underline | styleselect formatselect fontsizeselect | fullscreen",
        toolbar2: "bullist numlist | outdent indent blockquote | link unlink anchor image media code | inserttime preview | forecolor backcolor",
        relative_urls : false,
        convert_urls : true,
        menubar: false,
        toolbar_items_size: 'small',
        content_css : "<? echo Utils::getFileUrl("/css/tinymce.css")?>",
});</script>

<script>
function deleteNode(ele,id){
	if(!confirm("Remove?")){
		return
	}
	var deleteUrl = "<?php echo Yii::app()->baseUrl?>/node/delete/id/"+id;
	$.get(deleteUrl);
	$(ele).parent().parent().parent().remove();
	if($("tr").length <=1){
		location.reload();
	}
}
</script>

<?php if (!empty($expandNodeArr)):?>
<ol class="breadcrumb"  style='margin-bottom: 10px'>
	<?php foreach ($expandNodeArr as $expandNode):?>
	<li>
	<?php echo CHtml::link($expandNode->title,array("node/admin","id"=>$expandNode->id))?>
	</li>
	<?php endforeach;?>
	<li><?=$node->title ?></li>
</ol>
<?php endif;?>

<?php echo CHtml::form('','post',array('enctype'=>'multipart/form-data',"data-ajax"=>"false",'id'=>"form")); ?>

<div class='btn-group' style='margin-bottom: 10px'>
	<?=CHtml::link("New",array("node/add","id"=> empty($node)?"0":$node->id,"edit"=>true),array("class"=>"btn btn-primary"));?>
	<?=CHtml::submitButton('Save',array("class"=>"btn  btn-primary")); ?>
	<?=CHtml::link("Preview",['node/index','id'=>$node->id],['class'=>"btn btn-primary",'target'=>"_blank"])?>
</div>
<? echo CHtml::ActiveTextField($node,"title",array("class"=>"form-control margin-bottom-10",'placeholder'=>"标题"))?>
<? echo CHtml::ActiveHiddenField($node,"id",array("class"=>"form-control"))?>

<?if(!empty($node->sub_nodes)): ?>
<table class='table table-striped table-bordered'>
	<tr>
		<td style='width: 80px'>Seq</td>
		<td style='width: 80px'>Hits</td>
		<td>Title</td>
		<td style='width: 80px'>Parent</td>
		<td style='width: 130px'></td>
	</tr>
	<?php foreach($node->sub_nodes as $sub_node):?>
	<tr>
		<td><?php echo CHtml::textField("SubNodes[{$sub_node->id}][seq]",$sub_node->seq,array("value"=>$sub_node->seq,'class'=>"form-control")); ?>
		</td>
		<td><?php echo CHtml::textField("SubNodes[{$sub_node->id}][hits]",$sub_node->hits,array("value"=>$sub_node->hits,'class'=>"form-control")); ?>
		</td>
		<td><?php echo CHtml::textField("SubNodes[{$sub_node->id}][title]",$sub_node->title,array("value"=>$sub_node->title,'class'=>'form-control')); ?>
		</td>
		<td><?php echo CHtml::textField("SubNodes[{$sub_node->id}][parent_id]",$sub_node->parent_id,array('class'=>'form-control')); ?>
		</td>
		<td><?php echo CHtml::hiddenField("SubNodes[{$sub_node->id}][id]",$sub_node->id); ?>
			<div class='btn-group'>
				<?php  echo CHtml::link("Edit",array("node/admin","id"=>$sub_node->id),array("class"=>"btn btn-primary"))?>
				<?php  echo CHtml::link("Del","",array("onclick"=>"deleteNode(this,$sub_node->id)",'style'=>"cursor:pointer","class"=>'btn  btn-danger'))?>
			</div></td>
	</tr>
	<?php endforeach;?>
</table>

<?else: ?>

<div>
	<?=CHtml::ActiveTextarea($node,"content",array("class"=>"form-control","style"=>"height:600px",'id'=>'wysiwyg'))?>

	<?if (!empty($node->images)): ?>
	<div style='border: 1px dashed #bbb; padding: 5px;'
		class='margin-top-10'>
		<script>
	function insertImage(id){
		tinyMCE.execCommand('mceInsertContent',false,document.getElementById("image"+id).outerHTML);
	}
	function removeImage(id){
		$("#imagesDisplayDiv").append("<input type=hidden name=deleteImage[] value='"+id+"' />");
		$("#imageDiv"+id).remove();
		tinyMCE.activeEditor.dom.remove(tinyMCE.activeEditor.dom.select('#image'+id));
	}
	</script>
		<div id='imagesDisplayDiv' class='row'>
		<?php foreach ($node->images as $image):?>
		<div id='imageDiv<?php echo $image->id?>'
				class='col-md-3 col-sm-4 col-xs-6'
				style='text-align: center; margin: 5px 0; height: 120px; overflow: hidden'>
				<div class='margin-top-5 btn-group'>
					<button type='button' class='btn btn-success btn-sm'
						onclick='removeImage(<?=$image->id?>)'>删除</button>
					<button type='button' onclick="insertImage(<?=$image->id?>)"
						class='btn btn-success btn-sm'>插入</button>
				</div>
				<br /> <img id='image<?=$image->id?>'
					style='max-height: 100%; max-width: 100%;'
					src='<?php echo $image->getUrl();?>' />
			</div>
		<?php endforeach; ?>
	</div>
	</div>
<? endif;?>
<script>
function onFileSelect(){
	$("#form").submit();
	$("#uploading").show();
	$("#uploadDiv").hide();
	$("#doneDiv").hide();
}
</script>
	<div class='alert alert-danger' style='display: none;' id='uploading'>正在上传图片请等待。。。</div>
	<div class='margin-top-10' id='uploadDiv'>
		<label>上传图片(可以选多张)</label> <input id='file' type="file"
			name="nodeImage[]" onchange='onFileSelect()' multiple="multiple"
			accept='image/gif, image/jpeg, image/png'>
	</div>

</div>
<?endif; ?>

<div class='btn-group' style='margin: 10px 0'>
	<?=CHtml::link("New",array("node/add","id"=> empty($node)?"0":$node->id,"edit"=>true),array("class"=>"btn btn-primary"));?>
	<?=CHtml::submitButton('Save',array("class"=>"btn  btn-primary")); ?>
	<?=CHtml::link("Preview",['node/index','id'=>$node->id],['class'=>"btn btn-primary",'target'=>"_blank"])?>
</div>

<?php echo CHtml::endForm(); ?>

