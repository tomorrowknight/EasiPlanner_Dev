<?
use yii\helpers\Url;
$this->title = Yii::$app->name;
?>
<style>
.background-image {
	background: url(<?= Url :: to("@web/Noon.jpg")?>) no-repeat center center
		fixed;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	-webkit-filter: blur(5px);
	-moz-filter: blur(5px);
	-o-filter: blur(5px);
	-ms-filter: blur(5px);
	filter: blur(5px);
	-o-filter: blur(5px);
	-ms-filter: blur(5px);
	width: 100%;
	height: 100%;
	position: fixed;
	top:0;
	left: 0;
	right: 0;
	z-index: -1;
}
</style>
<div class="background-image"></div>
<div style='max-width: 1024px; margin: auto; text-shadow: 1px 1px #888;color:#fff'>
	<div class="jumbotron">
		<h1>Welcome to <?=Yii::$app->name ?>!</h1>
		<p>The future of cloud based routing and dispatching planning at you
			fingertips.</p>
		<p>
			<a class="btn btn-primary btn-lg" href="/user/login" role="button" style='text-shadow: none'>Learn more</a>
		</p>
	</div>

	<div class="container">
		<!-- Example row of columns -->
		<div class="row">
			<div class="col-md-4">
				<h2>Summary</h2>
				<p>A map based tool for intra-city routing and despatching based on
					time windows for Singapore</p>
			</div>
			<div class="col-md-4">
				<h2>Technology</h2>
				<p>Cloud based system which uses algorithms that allow for easy
					routing and dispatching with time windows.</p>
			</div>
			<div class="col-md-4">
				<h2>Benefits</h2>
				<p>This is a highly cost effective,quick and flexible solution for
					your route planning needs.</p>
			</div>
		</div>

	</div>
</div>