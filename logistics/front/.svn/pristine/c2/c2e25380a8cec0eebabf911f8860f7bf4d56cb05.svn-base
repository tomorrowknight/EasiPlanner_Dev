<?php

namespace chief725\libs;

use yii\console\Exception;

class Text {
	public static function autoLink($text) {
		return preg_replace ( '@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.\-]*(\?\S+)?)?)?)@', '<a href="$1">$1</a>', $text );
	}
}