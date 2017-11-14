<?php 
spl_autoload_register(function($className){
	$dirClass =  __DIR__ .DIRECTORY_SEPARATOR."src" .DIRECTORY_SEPARATOR."app";
	$filename = $dirClass.DIRECTORY_SEPARATOR.$className.".php";

	if (file_exists($filename)) {
		require_once($filename);
	}
});

require __DIR__ . '/vendor/autoload.php';



