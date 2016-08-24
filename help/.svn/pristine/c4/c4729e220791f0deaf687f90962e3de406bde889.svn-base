<div data-role="page">
	<div data-role="header">
		<h1>
			<?=Config::get(Config::$app_name)?>
		</h1>

		<?php if (!empty($node->parent)):?>
		<?php echo CHtml::link("Back",array("node/index","id"=>$node->parent_id),array("data-icon"=>"back", "data-direction"=>"reverse","class"=>"ui-btn-left",'data-transition'=>"slide"))?>
		<?php endif;?>
	</div>
	<div role="main" class="ui-content">
		<h2>
			<?=$node->title?>
		</h2>
		<?php if (!empty($node->sub_nodes)):?>
		<ul data-role="listview">
			<?php foreach ($node->sub_nodes as $sub_node):?>
			<li><a data-transition="slide"
				href='<?=$sub_node->getUrl()?>'
				<?if( Config::isEnable("prefetch")) echo "data-prefetch"?>
				 ><?=$sub_node->title?>
			</a> <?php endforeach;?>
		</ul>
		<?php endif;?>
		<?php echo $node->content?>

		<?php $content = trim(strip_tags($node->content));?>
		<?php if (empty($node->sub_nodes) && empty($node->content)):?>
		<div class='jumbotron'>
			<p>This page is in construction.</p>
		</div>
		<?php endif?>
	</div>
	<div data-role="footer">
		<h4>
			@ 2001-
			<?php echo date("Y")?>
		</h4>
	</div>
</div>

