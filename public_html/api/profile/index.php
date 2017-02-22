<?php

require_once dirname(__DIR__,3)."/php/classes/autoload.php";
require_once dirname(__DIR__,3)."/lib/xsrf.php";
require_once "/etc/apache2/capstone-mysql/encrypted-config.php";

use Edu\Cnm\SproutSwap\Profile;

/**
 * API for Profile class
 *
 * @author Solomon Leyba <solomon.leyba@gmail.com>
 */

//check session status; if not active then starts the session
if(session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}

//preparing empty reply; this will be used to store the results of our call to the api
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/profile.ini");

	//determines which HTTP method needs to be processed and stores it in $method
	$method = array_key_exists("HTTP_x_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//stores primary key for the GET, DELETE, and PUT methods in $id
	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$imageId = filter_input(INPUT_GET, "imageId", FILTER_VALIDATE_INT);
	$activation = filter_input(INPUT_GET, "activation", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$email = filter_input(INPUT_GET, "email", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$handle = filter_input(INPUT_GET, "handle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$name = filter_input(INPUT_GET, "name", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$summary = filter_input(INPUT_GET, "summary", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//ensure id is valid for methods requiring it
	if(($method === "DELETE" || $method === "PUT") && empty($id) === true || $id < 0){
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	//handle GET requests, if id is present then grab that profile otherwise grab array
	if($method === "GET"){

		//set XSRF cookie
		setXsrfCookie();

		//get a specific profile or all applicable profiles and update reply
		if(empty($id) === false){
			$profile = Profile::getProfileByProfileId($pdo, $id);
			if($profile !== null){
				$reply->data = $profile;
			}
		} else if(empty($imageId) === false){
			$profile = Profile::getProfileByProfileImageId($pdo, $imageId);
			if($profile !== null){
				$reply->data = $profile;
			}
		} else if(empty($activation) === false) {
			$profile = Profile::getProfileByProfileActivation($pdo, $activation);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} else if(empty($email) === false) {
			$profile = Profile::getProfileByProfileEmail($pdo, $email);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} else if(empty($handle) === false){
			$profile = Profile::getProfileByProfileHandle($pdo, $handle);
			if($profile !== null){
				$reply->data = $profile;
			}
		} else if(empty($name) === false){
			$profiles = Profile::getProfileByProfileName($pdo, $name);
			if($profiles !== null){
				$reply->data = $profiles;
			}
		} else if(empty($summary) === false){
			$profiles = Profile::getProfileByProfileSummary($pdo, $summary);
			if($profiles !== null){
				$reply->data = $profiles;
			}
		} else{
			$profiles = Profile::getAllProfiles($pdo);
			if($profiles !== null){
				$reply->data = $profiles;
			}
		}
	} else if($method === "PUT" || $method === "POST"){

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure profile email is available (required field)
		if(empty($requestObject->profileEmail) === true){
			throw(new \InvalidArgumentException("No profile email found", 405));
		}
		//make sure profile handle is available (required field)
		if(empty($requestObject->profileHandle) === true){
			throw(new \InvalidArgumentException("No profile handle found", 405));
		}
		//make sure profile timestamp is accurate (optional field)
		if(empty($requestObject->profileTimestamp) === true){
			$requestObject->profileTimestamp = new \DateTime();
		}
		//check for image id and explicitly assign to null if none (optional field)
		if(empty($requestObject->profileImageId) === true){
			$requestObject->profileImageId = null;
		}

		//perform the actual put or post
		if($method === "PUT"){

			//retrieve the profile to be updated
			$profile = Profile::getProfileByProfileId($pdo, $id);
			if($profile === null){
				throw(new RuntimeException("Profile does not exist", 404));
			}

			//update all attributes
			$profile->setProfileImageId($requestObject->profileImageId);
			$profile->setProfileActivation($requestObject->profileActivation);
			$profile->setProfileEmail($requestObject->profileEmail);
			$profile->setProfileHandle($requestObject->profileHandle);
			$profile->setProfileName($requestObject->profileName);
			$profile->setProfilePasswordHash($requestObject->profilePasswordHash);
			$profile->setProfileSalt($requestObject->profileSalt);
			$profile->setProfileSummary($requestObject->profileSummary);
			$profile->update($pdo);
		} else if($method === "POST"){

			//create new profile and insert into database
			$profile = new Profile(null, $requestObject->profileImageId, $requestObject->profileActivation, $requestObject->profileEmail, $requestObject->profileHandle, $requestObject->profileHandle, null, $requestObject->profileName, $requestObject->profilePasswordHash, $requestObject->profileSalt, $requestObject->profileSummary);
			$profile->insert($pdo);

			//update reply
			$reply->message = "Profile created ok";
		}
	} else{
		throw(new InvalidArgumentException("Invalid HTTP method request"));
	}
		//update reply with exception information
} catch(Exception $exception){
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError){
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null){
	unset($reply->data);
}

//encode and return reply to front end caller
echo json_encode($reply);