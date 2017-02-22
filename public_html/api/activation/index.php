<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\SproutSwap\Profile;


/**
 * api for the Profile Activation class
 *
 * @author Zak Abad<abad.zacaria@gmail.com>
 **/

//verify the session, start if not active
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

	//sanitize activation input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$activation = filter_input(INPUT_GET, "activate", FILTER_VALIDATE_STRING);
	$content = filter_input(INPUT_GET, "content", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("Invalid Activation"));
	}


	// handle GET request - if id is present, that activation is returned, otherwise all activations are returned
	if($method === "GET") {

		//set XSRF cookie
		setXsrfCookie();

		//get a specific Sign up based on the given field
		$emailActivation = filter_input(INPUT_GET, "emailActivation", FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($emailActivation)) {
			throw(new \RangeException("No Activation"));
		}
		$profile = Profile::getProfileByProfileActivation($pdo, $emailActivation);
		if(empty($profile)) {
			throw(new \InvalidArgumentException("No profile for Activation"));
		}
		$profile->setProfileActivation(null);
		$profile->update($pdo);
		$reply->message = "Profile Activated";
	}else{
		throw (new\Exception("Invalid HTTP method"));
		}

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//  make sure profile activation is available
		if(empty($requestObject->profileActivation) === true) {
			throw(new \InvalidArgumentException ("No Profile Activation"));
		}

	// update reply with exception information
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
	header("Content-type: application/json");
	echo json_encode($reply);
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
	$reply->trace = $typeError->getTraceAsString();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);