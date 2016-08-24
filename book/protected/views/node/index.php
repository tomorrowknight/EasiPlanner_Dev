<div class='row'>
	<div class='col-sm-4 col-lg-3  hidden-xs'>
		<h4>
			<? echo CHtml::link("<i class='glyphicon glyphicon-book'></i> ".Config::get(Config::$app_name),array("node/index"),array("class"=>""))?>
		</h4>

		<? echo Utils::output(Node::getRootNode(),1,$expandArr);?>
	</div>

	<div class='col-sm-8 col-lg-9'>
		<?php if (!empty($expandNodeArr)):?>
		<ol class="breadcrumb">
			<?php foreach ($expandNodeArr as $expandNode):?>
			<li>
			<?php echo CHtml::link($expandNode->title,array("node/index","id"=>$expandNode->id))?>
			</li>
			<?php endforeach;?>
		</ol>
		<?php endif;?>

		<h3>
			<? echo $node->title?>
			<? echo CHtml::link("<i class='glyphicon glyphicon-edit'></i>",array("node/admin","id"=>$node->id))?>
		</h3>
		<div class='hidden-xs'>
			<? $this->renderAds("ads-mix")?>
		</div>

		<? echo Utils::output($node,3);?>
		<? echo $node->content?>

		<?php $content = trim(strip_tags($node->content));?>
		<?php if (empty($node->sub_nodes) && empty($content)):?>
		<div class='jumbotron'>
			<p>This page is in construction.</p>
		</div>
		<?php endif?>

		<? $this->renderAds("ads-mix")?>
		<div class='hidden-md hidden-lg hidden-sm'>
			<?
			if (empty ( $node->children ) && ! empty ( $node->parent )) {
				echo "<h3>{$node->parent->title}</h3>";
				echo Utils::output ( $node->parent, 1 );
			}
			?>
		</div>
	</div>
</div>
