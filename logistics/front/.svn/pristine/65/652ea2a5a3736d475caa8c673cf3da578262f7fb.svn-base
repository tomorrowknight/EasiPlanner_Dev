<?php
use chief725\libs\GoogleMap;

use chief725\libs\Log;
use chief725\libs\File;


date_default_timezone_set("asia/shanghai");

include 'vendor/autoload.php';

#Test File/globRecursive
$file = new File();
$files = File::globRecursive(".");
assert(count($files)>0);


#Test File/stat
Log::$level = "INFO";
File::stat(".");

#Test File/rmDir
@mkdir("folder");
@mkdir("folder/folder");
File::rmDir("folder");
assert(!file_exists("folder"));

#Test Google map

$googlemap = new GoogleMap;
print_r($googlemap->getLatLng("sg 730519",'sg'));
