<?php

namespace chief725\libs;

class Location {
	public static function GeoIp($ip) {
		$geocode_url = "http://ip.orgs.one/json/$ip";
		return json_decode ( file_get_contents ( $geocode_url ) );
	}
}