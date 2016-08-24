<?php $this->beginContent('//layouts/main'); ?>
		<?php
		$navs = array (
				array (
						'label' => 'Config',
						'url' => array (
								'admin/config'
						)
				),
				array (
						'label' => 'Articles',
						'url' => array (
								'node/admin'
						)
				),
				array (
						"label" => "Links",
						"url" => array (
								"model/index",
								"modelClass" => "Link"
						)
				),
				array (
						'label' => 'Refresh',
						'url' => array (
								'admin/refresh'
						)
				)
		);

		$this->widget ( 'zii.widgets.CMenu', array (
				'items' => $navs,
				'htmlOptions' => array (
						"class" => 'nav nav-tabs margin-bottom-10'
				)
		) );
		?>

<div class='inner'>
	<?php echo $content?>
</div>
<?php $this->endContent(); ?>
