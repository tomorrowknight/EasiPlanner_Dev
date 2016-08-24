<?php
namespace chief725\libs;

use yii\helpers\Html;

class Share{
	public static function display($buttonKeys,$url,$title) {
		 
		$buttons = array(
				'facebook' => [
					"text"=> '臉書',
					"url"=> "http://www.facebook.com/sharer.php?u=$url",
					"btn"=> "primary"
				],
				'weixin' => [
					"text"=> "微信",
					"url"=> "http://apps.example8.com/app/wechat?url=$url",
					"btn"=> "success"
				],
				'weibo' => [
					"text"=> '微博',
					"url"=> "http://service.weibo.com/share/share.php?url=$url&title=$title",
					"btn"=> "warning"
				],
				'qzone' => [
					"text"=> 'QQ',
					"url"=> "http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=$url",
					"btn"=> "info"
				],
				'line'=>[
					"text"=> "Line",
					"url"=> "http://line.me/R/msg/text/?{$title}%0D%0A$url",
					"btn"=> "success"
				]
		);
		 
		$btnHtmls = [];
		foreach ($buttonKeys as $buttonKey) {
			$button = (object) $buttons[$buttonKey];
			$btnHtmls[] = "<a href='{$button->url}' target=_blank class='btn btn-large btn-{$button->btn}'>{$button->text}</a>";
		}
		
		return Html::tag('div',join("", $btnHtmls),['class'=>"btn-group"]);
	}
}
?>