<?php

require_once "autoloader.php";
require_once "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Zabad1\SproutSwap;


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

		//make sure profile id is available (required field)
		if(empty($requestObject->profileId) === true) {
			throw(new \InvalidArgumentException ("No Profile Id", 405));
		}

		// make sure profile image id is accurate (optional field)
		if(empty($requestObject->profileImageId) === true) {
			throw (new \InvalidArgumentException("No Profile Image Id");
		}

		//  make sure profile activation is available
		if(empty($requestObject->profileActivation) === true) {
			throw(new \InvalidArgumentException ("No Profile Activation"));
		}

		// make sure profile email is correct
		if(empty($requestObject->profileEmail) === true){
			throw(new \InvalidArgumentException("No Profile Email"));

			//make sure profile handle is correct
			if(empty($requestObject->profileHandle) === true){
				throw(new \InvalidArgumentException("No Profile Handle"));
			}

			//make sure profile name is correct
			if(empty($requestObject->profileName) === true){
				throw(new \InvalidArgumentException("No Profile Name"));
			}

			//make sure profile password hash is correct
			if(empty($requestObject->profilePasswordHash) === true){
				throw (new \InvalidArgumentException("No Profile Password Hash"));
			}

			//make sure profile salt must be correct
			if(empty($requestObject->profileSalt) === true){
				throw (new \InvalidArgumentException("No Profile Salt"));
			}

		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the tweet to update
			$profile = Profile::getProfileByProfileId($pdo, $id);
			if($profile === null) {
				throw(new RuntimeException("Profile does not exist", 404));
			}

			// update all attributes
			$profile->setProfileActivation($requestObject->profileActivation);
			$profile->setProfileEmail($requestObject->profileEmail);
			$profile->setProfileHandle($requestObject->profileHandle);
			$profile->setProfileName($requestObject->profileName);
			$profile->setProfilePasswordHash($requestObject->profilePasswordHash);
			$profile->setProflieSalt($requestObject->profileSalt);
			$profile->update($pdo);

			// update reply
			$reply->message = "Profile updated OK";

		} else if($method === "POST") {

			// create new profile and insert into the database
			$profile = new Profile(null, $requestObject->profileId, $requestObject->profileEmail, null);
			$tweet->insert($pdo);

			// update reply
			$reply->message = "Profile created OK";
		}

	} else if($method === "DELETE") {
		verifyXsrf();

		// retrieve the Profile to be deleted
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("Profile does not exist", 404));
		}

		// delete activation
		$activation->delete($pdo);

		// update reply
		$reply->message = "Profile deleted OK";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request"));
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