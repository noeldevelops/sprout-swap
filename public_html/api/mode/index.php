<?php

require_once dirname(__DIR__,3)."/php/classes/autoload.php";
require_once dirname(__DIR__, 3)."/lib/xsrf.php";
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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/tweet.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$modeId = filter_input(INPUT_GET, "modeId", FILTER_VALIDATE_INT);
	$modeName = filter_input(INPUT_GET, "modeName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure id is valid
	if(($method === "DELETE" || $method === "PUT") && (empty($modeId) === true || $modeId < 0)) {
		throw(new InvalidArgumentException("modeId cannot be empty or negative", 405));
	}

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
	} elseif($method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		if(empty($requestObject->modeName) === true) {
			throw(new \InvalidArgumentException("No Mode Name", 405));
		}
		if($method == "POST") {

			//create a new mode and insert it into database
			$mode = new Mode(null, $requestObject->imageCloudinaryId);
			$mode->insert($pdo);

			$reply->message = "New mode was created";
		}
	} elseif($method === "DELETE") {
		verifyXsrf();

		$mode = Mode::getModeByModeId($pdo, $modeId);
		if($mode === null) {
			throw(new RuntimeException("Mode does not exist", 404));
		}
		//delete the mode
		$mode->delete($pdo);

		$reply->message = "Mode successfully deleted";
	} else {
		throw(new InvalidArgumentException("Invalid HTTP Method Request"));
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