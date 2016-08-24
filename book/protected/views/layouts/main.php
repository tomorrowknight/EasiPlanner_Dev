<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description"
	content="<?php echo empty($this->pageDescription)?$this->pageTitle:$this->pageDescription;?>">
<meta name='keywords'
	content='<?php echo empty($this->pageKeywords)?$this->pageTitle:$this->pageKeywords;?>'>
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<?php
$cs = Yii::app ()->clientScript;
$cs->scriptMap = array (
		'jquery.js' => Yii::app ()->request->baseUrl . '/external/jquery-1.9.1.min.js'
);
Yii::app ()->clientScript->registerCoreScript ( 'jquery' );

Utils::load ( array (
		"/css/base.css?v=".filemtime(Utils::getFilePath("/css/base.css")),
		"/external/bootstrap/css/bootstrap.css",
		"/external/bootstrap/js/bootstrap.js",
) );
?>

<link rel="apple-touch-icon"
	href="<?php echo Utils::getFileUrl("/imgs/icon.png")?>" />

<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<!--[if lt IE 9]>
      <script src="<?php echo Yii::app ()->request->baseUrl ?>/external/bootstrap/js/html5shiv.js"></script>
      <script src="<?php echo Yii::app ()->request->baseUrl ?>/external/bootstrap/js/respond.min.js"></script>
<![endif]-->
</head>
<body>
	<header class="navbar navbar-default  bs-docs-nav">
		<div class="container">
			<div class="navbar-header">
				<?php echo CHtml::link('<i class="glyphicon glyphicon-book" style="font-size:85%"></i> '.Config::get(Config::$app_name),array("node/index"),array("class"=>"navbar-brand",'style'=>'font-size:24px;font-weight:bold;margin:-3px 0;'))?>
			</div>
			<nav class="collapse navbar-collapse bs-navbar-collapse">
				<?
				$links = Link::model()->findAll(array("order"=>"seq asc",'condition'=>"domain='".DOMAIN."'"));
				$navs = array ();
				foreach ($links as $link){
					array_push ( $navs, array('label' => "<i class='glyphicon glyphicon-link'></i> $link->title", 'url' => "http://$link->url",'linkOptions'=>array("target"=>"_blank")) );
				}
				$this->widget ( 'zii.widgets.CMenu', array (
						'items' => $navs,
						'encodeLabel' => false,
						'htmlOptions' => array (
								"class" => 'nav navbar-nav'
						)
				) );

				$navs = array ();
				if (Yii::app ()->user->isGuest) {
					array_push ( $navs, array (
							'label' => '<span class="glyphicon glyphicon-log-in" ></span> Login',
							'url' => array (
									"site/login"
							)
					) );
				} else {
					array_push ( $navs, array (
							'label' => '<span class="glyphicon glyphicon-log-out"></span> Logout',
							'url' => array (
									"site/logout"
							)
					) );
				}
				$this->widget ( 'zii.widgets.CMenu', array (
						'items' => $navs,
						'encodeLabel' => false,
						'htmlOptions' => array (
								"class" => 'nav navbar-nav  pull-right'
						)
				) );
				?>

			</nav>
		</div>

	</header>

	<div class="container" style='position: relative'>
		<? $this->renderAds("fluidads")?>
		<div class='module mod-line-top'>
			<?php echo $content; ?>
		</div>
	</div>
	<div class="container" style=''>
		<div class='module mod-line-top'>

			<p>
				&copy; Copyright 2005–
				<?php echo date("Y")?>
			</p>
			<div style='clear: both'></div>
		</div>
	</div>

	<? echo Config::get(Config::$footer_text)?>

	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-19409266-37', 'singask.com');
	  ga('send', 'pageview');

	</script>

	<?php if (Config::isEnable("highlight")):?>
	<?php
	Utils::load ( array (
			"/external/syntax/shCore.js",
			"/external/syntax/shBrushJScript.js",
			"/external/syntax/shCore.css",
			"/external/syntax/shThemeDefault.css",
	) );
	?>
	<script>
	$(function(){
	    SyntaxHighlighter.all();
	});
	</script>
	<?php endif;?>

	<script src='//cdn.example8.com/jianfan.js'></script>
</body>

</html>
