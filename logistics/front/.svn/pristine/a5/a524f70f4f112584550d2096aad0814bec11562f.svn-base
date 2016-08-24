<?php

namespace chief725\libs;

class Constellation {
	private $birthday;
	private $birthdayTime;
	public function __construct($birthday) {
		$this->birthday = $birthday;
		$this->birthdayTime = strtotime ( $birthday );
	}
	public function getYear() {
		return date ( "y", $this->birthdayTime );
	}
	public function getMonth() {
		return date ( "m", $this->birthdayTime );
	}
	public function getDay() {
		return date ( "d", $this->birthdayTime );
	}
	public function getConstellation() {
		$day = $this->getDay ();
		$month = $this->getMonth ();
		if ($month < 1 || $month > 12 || $day < 1 || $day > 31)
			return false;
		$signs = array (
				array (
						'20' => '宝瓶座' 
				),
				array (
						'19' => '双鱼座' 
				),
				array (
						'21' => '白羊座' 
				),
				array (
						'20' => '金牛座' 
				),
				array (
						'21' => '双子座' 
				),
				array (
						'22' => '巨蟹座' 
				),
				array (
						'23' => '狮子座' 
				),
				array (
						'23' => '处女座' 
				),
				array (
						'23' => '天秤座' 
				),
				array (
						'24' => '天蝎座' 
				),
				array (
						'22' => '射手座' 
				),
				array (
						'22' => '摩羯座' 
				) 
		);
		list ( $start, $name ) = each ( $signs [$month - 1] );
		if ($day < $start)
			list ( $start, $name ) = each ( $signs [($month - 2 < 0) ? 11 : $month - 2] );
		return $name;
	}
}