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
) );
?>

<link rel="stylesheet"
	href="http://code.jquery.com/mobile/1.4.3/jquery.mobile-1.4.3.min.css" />
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script
	src="http://code.jquery.com/mobile/1.4.3/jquery.mobile-1.4.3.min.js"></script>
<?php Utils::load(array(
		"/css/rp.css",
		"/css/jquery.mobile.icons.min.css"
		))?>
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<link rel="apple-touch-icon"
	href="<?php echo Utils::getFileUrl("/imgs/icon.png")?>" />
</head>
<body>




	<?php echo $content; ?>


	<? echo Config::get(Config::$footer_text)?>

	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-19409266-37', 'singask.com');
	  ga('send', 'pageview');
	
	</script>
</body>

</html>
