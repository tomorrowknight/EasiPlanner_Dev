<?php
namespace chief725\libs;

class File{
    public static function globRecursive($folder,$pattern=".*") {
    	if (!file_exists($folder))
    		return [];
    	$matchedFiles = [];
    	$allFiles = scandir($folder);
    	foreach ($allFiles as $file){
    		if (in_array($file,array(".",".."))) continue;
    		$filePath = "$folder/$file";
    		if (is_dir($filePath)){
    			$matchedFiles = array_merge($matchedFiles,self::globRecursive($filePath, $pattern));
    		}elseif (preg_match("/$pattern/", $filePath)){
    			$matchedFiles[] = $filePath;
    		}
    	}
    	return $matchedFiles;
    }
    
    public static function rmDir($dir) {
    	if (!file_exists($dir)) return;
    	$files = array_diff(scandir($dir), array('.','..'));
    	foreach ($files as $file) {
    		(is_dir("$dir/$file")) ? self::rmDir("$dir/$file") : unlink("$dir/$file");
    	}
    	return rmdir($dir);
    }
    
    public static function stat($folders){
    	if (!is_array($folders)) $folders = [$folders];
    	
    	$fileSizeTotal = 0;
    	foreach ($folders as $folder){
    		$files = self::globRecursive($folder);
    		$folderSize = 0;
    		$fileCount = 0;
    		foreach ($files as $file){
    			$folderSize += filesize($file);
    			$fileCount++;
    		}
    		$fileSizeTotal+=$folderSize;
    		Log::info("Folder $folder size: ".number_format($folderSize/ pow(1024,2))." MB");
    		Log::info("$folder count: ".number_format($fileCount));
    	}
    	Log::info("=========================");
    	Log::info("Total File Size : ".number_format($fileSizeTotal/ pow(1024,2))." MB");
    }
}
?>