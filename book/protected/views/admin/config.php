<h1>Configuration</h1>
<form action="" method='post'>
	<?php
	$class = new ReflectionClass ( "Config" );
	foreach ( $class->getStaticProperties () as $key => $value ) :
		?>
	<div class='form-group'>
		<label><?php echo $key?>:
		</label>
		<?php if(preg_match("/_text$/", $key)):?>
		<textarea name='<?php echo $key?>' style='width: 90%; height: 90px;'  class='form-control'><?php echo Config::get($key);?></textarea>
		<?php else:?>
		<input type='text' name='<?php echo $key?>' class='form-control'
			value='<?php echo Config::get($key);?>' />
		<?php endif;?>
	</div>
	<?php endforeach;?>
	<input type='submit' value='Submit' class='btn btn-primary' />
</form>
