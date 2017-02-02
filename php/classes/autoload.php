<?PHP
spl_autoload_register(function($class){
	//$prefix = namespace
	//$baseDir = base directory
	$prefix = "Edu\\Cnm\\SproutSwap";
	$baseDir = __DIR__;

	// check if class uses namespace
	$len = strlen($prefix);
	if(strncmp($prefix, $class, $len) !== 0){
		//if no, move on
		return;
	}

	// grab relative class name
	$className = substr($class, $len);

	//replacing namespace with base directory structure
	$file = $baseDir . str_replace("\\", "/", $className) . ".php";
	//require the file if it exists
	if(file_exists($file)){
		require_once($file);
	}
});