<?php

require_once dirname(__DIR__,3)."/php/classes/autoload.php";
require_once dirname(__DIR__, 3)."/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\SproutSwap\Mode;

/**
 * api for Mode class
 *
 * @author Noel Cothren <noelcothren@gmail.com>
 **/

//verify session and start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/sprout-swap.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$modeId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$modeName = filter_input(INPUT_GET, "modeName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//handle GET request
	if($method == "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific mode of all modes and update reply
		if(empty($modeId) === false) {
			$mode = Mode::getModeByModeId($pdo, $modeId);
			if($mode !== null) {
				$reply->data = $mode;
			}
		} elseif(empty($modeName) === false) {
			$modes = Mode::getModeByModeName($pdo, $modeName);
			if($modes !== null) {
				$reply->data = $modes;
			}
		} else {
			$modes = Mode::getAllModes($pdo);
			if($modes !== null) {
				$reply->data = $modes;
			}
		}
	}

} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);