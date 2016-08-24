<?php
namespace chief725\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class WebsiteWidget extends Widget{
	public $url;
	public $icon;
	public $title;
	public $content;
	public $background;
	public $size;
	
	public function init(){
		parent::init();
		if (empty($this->background)){
			$this->background = "#4864B4";
		}
		if (empty($this->size)){
			$this->size = "45px";
		}
	}
	
	public function run(){
		$html = <<<EOT
		<div class='alert' style='background: $this->background;padding:10px;'>
			<div class="media">
				<a style='display: block; color: #fff;text-decoration:none' href="$this->url">
					<div class="media-left">
						<img class="media-object" src="$this->icon"	style='width: $this->size; height: $this->size;'>
					</div>
					<div class="media-body">
						<h4 class="media-heading">$this->title</h4>
						$this->content
					</div>
				</a>
			</div>
		</div>
EOT;
		return $html;
	}
}
?>