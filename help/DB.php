<?php 
define("DB_HOST","localhost");
define("DB_USERNAME","root");
$domain =preg_replace(array("/^www\./","/^m\./","/:\d+$/"), "", $_SERVER['HTTP_HOST']) ;
define("DOMAIN",$domain);
define("DB_NAME","book");
define("DB_PASSWORD","lzj1986!");

?>