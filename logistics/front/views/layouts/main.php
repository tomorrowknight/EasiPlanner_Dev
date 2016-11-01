<?
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use chief725\libs\Utils;

?>

<?php $this->beginContent('@app/views/layouts/base.php'); ?>
<div class="wrap">
	<?php
	NavBar::begin([
			'brandLabel' => Utils::iconfa("car").Yii::$app->name,
			'brandUrl' => Yii::$app->homeUrl,
			'options' => [
			'class' => 'navbar-default navbar-fixed-top',
			],
			]);
	echo $this->render("_nav");
	NavBar::end();
	?>
	<div class="container">
		<?= Breadcrumbs::widget([
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
		<?php
		foreach(Yii::$app->session->getAllFlashes() as $key => $message) {
			echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
		}
		?>
		<?= $content ?>
	</div>
</div>

<footer class="footer">
	<div class="container">
		<p class="pull-left">
			&copy; Republic Polytechnic - COI-SCM
			<?= date('Y') ?>
		</p>
	</div>
</footer>
<?php $this->endContent(); ?>
