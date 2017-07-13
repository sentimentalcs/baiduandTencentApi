<?php 

	define('OFFICE2TEXTROOT_PATH',__DIR__);
	
	spl_autoload_register(function($class){
		$namespace = str_replace('\\', DIRECTORY_SEPARATOR, $class);
			
		$file_path = dirname(OFFICE2TEXTROOT_PATH).DIRECTORY_SEPARATOR.$namespace.'.php';
		if(file_exists($file_path)){
			include $file_path;
		}
	},false,true);	