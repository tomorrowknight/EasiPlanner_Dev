<?php

namespace chief725\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class ErrorsWidget extends Widget {
	public function init() {
		parent::init ();
	}
	public function run() {
		$errors = [ ];
		foreach ( $model->getErrors () as $errors ) {
			foreach ( $errors as $error ) {
				$errors [] = "<li>$error</li>";
			}
		}
		$errorHtml = join ( "", $errors );
		
		$html = <<<EOT
		<div class="alert alert-danger">
			<h3>错误</h3>
			<ul>$errorHtml</ul>
		</div>
EOT;
		return $html;
	}
}
?>