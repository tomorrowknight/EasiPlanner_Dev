<?php

namespace app\libs;

class U {
	public static function date2Label($date) {
		if ($date == date ( "Y-m-d" ))
			return "Today";
		if ($date == date ( "Y-m-d", strtotime ( "-1 day" ) ))
			return "Yesterday";
		if ($date == date ( "Y-m-d", strtotime ( "+1 day" ) ))
			return "Tomorrow";
		return $date;
	}
}