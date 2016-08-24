
<?php Utils::loadJs("/external/tiny_mce/jquery.tinymce.js")?>
<script>
<?php if (!isset($_GET['type'])) :?>
$().ready(function() {
	$('#wysiwyg').tinymce({
		// Location of TinyMCE script
		script_url : '<?php echo Utils::getFileUrl('/external/tiny_mce/tiny_mce.js')?>',

		// General options
		theme : "advanced",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,removeformat,code,|,justifyleft,justifycenter,formatselect,fontsizeselect,bullist,numlist,|,link,unlink,image,|,forecolor",
		theme_advanced_buttons2 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_resizing : true,
		content_css : "<?php echo Utils::getFileUrl('/external/tiny_mce/custom_content.css')?>"
	});
});
<?php endif;?>
</script>


<?php echo CHtml::form('','post',array("data-ajax"=>"false","id"=>"namecardForm",'class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
<fieldset class='clearfix'>
	<h2>
		<?php echo $title?>
	</h2>
	<textarea style='width:100%; height:400px;' id="wysiwyg" name='content'><?php echo $content?></textarea>
	<br />

	<div class="form-actions">
		<input type="submit" value="完成" class="btn btn-primary">
	</div>
</fieldset>
<?php echo CHtml::endForm(); ?>

