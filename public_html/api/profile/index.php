<?php

require_once dirname(__DIR__,3)."/php/classes/autoload.php";
require_once dirname(__DIR__,3)."/php/lib/xsrf.php";
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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/sprout-swap.ini");

	//determines which HTTP method needs to be processed and stores it in $method
	$method = array_key_exists("HTTP_x_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//stores primary key for the GET, DELETE, and PUT methods in $id
	//sanitize input
	$profileId = filter_input(INPUT_GET, "profileId", FILTER_VALIDATE_INT);
	$profileImageId = filter_input(INPUT_GET, "profileImageId", FILTER_VALIDATE_INT);
	$profileActivation = filter_input(INPUT_GET, "profileActivation", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileHandle = filter_input(INPUT_GET, "profileHandle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileName = filter_input(INPUT_GET, "profileName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileSummary = filter_input(INPUT_GET, "profileSummary", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//ensure id is valid for methods requiring it
	if(($method === "DELETE" || $method === "PUT") && (empty($profileId) === true || $profileId < 0)){
		throw(new InvalidArgumentException("Profile ID is empty or invalid.", 405));
	}

	//handle GET requests, if id is present then grab that profile otherwise grab array
	if($method === "GET"){

		//set XSRF cookie
		setXsrfCookie();

		//get a specific profile or all applicable profiles and update reply
		if(empty($profileId) === false){
			$profile = Profile::getProfileByProfileId($pdo, $profileId);
			if($profile !== null){
				$reply->data = $profile;
			}
		} else if(empty($profileImageId) === false){
			$profile = Profile::getProfileByProfileImageId($pdo, $profileImageId);
			if($profile !== null){
				$reply->data = $profile;
			}
		} else if(empty($profileActivation) === false) {
			$profile = Profile::getProfileByProfileActivation($pdo, $profileActivation);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} else if(empty($profileEmail) === false) {
			$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} else if(empty($profileHandle) === false){
			$profile = Profile::getProfileByProfileHandle($pdo, $profileHandle);
			if($profile !== null){
				$reply->data = $profile;
			}
		} else if(empty($profileName) === false){
			$profiles = Profile::getProfileByProfileName($pdo, $profileName)->toArray();
			if($profiles !== null){
				$reply->data = $profiles;
			}
		} else if(empty($profileSummary) === false){
			$profiles = Profile::getProfileByProfileSummary($pdo, $profileSummary)->toArray();
			if($profiles !== null){
				$reply->data = $profiles;
			}
		} else{
			$profiles = Profile::getAllProfiles($pdo)->toArray();
			if($profiles !== null){
				$reply->data = $profiles;
			}
		}
	} else if($method === "PUT" || $method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure profile email is available (required field)
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException("No profile email found", 405));
		}
		//make sure profile handle is available (required field)
		if(empty($requestObject->profileHandle) === true) {
			throw(new \InvalidArgumentException("No profile handle found", 405));
		}

		//check for image id and explicitly assign to null if none (optional field)
		if(empty($requestObject->profileImageId) === true) {
			$requestObject->profileImageId = null;
		}

		//perform the actual put or post
		if($method === "PUT"){

			//retrieve the profile to be updated
			$profile = Profile::getProfileByProfileId($pdo, $profileId);
			if($profile === null){
				throw(new RuntimeException("Profile does not exist", 404));
			}

			//update all non password attributes
			$profile->setProfileImageId($requestObject->profileImageId);
			$profile->setProfileEmail($requestObject->profileEmail);
			$profile->setProfileHandle($requestObject->profileHandle);
			$profile->setProfileName($requestObject->profileName);
			$profile->setProfileSummary($requestObject->profileSummary);

			//change password if requested
			if(empty($requestObject->currentProfilePassword) === false && empty($requestObject->newProfilePassword) === false && empty($requestContent->confirmProfilePassword) === false) {
				if($requestObject->newProfilePassword !== $requestObject->confirmProfilePassword) {
					throw(new RuntimeException("New passwords do not match", 401));
				}

				$currentPasswordHash = hash_pbkdf2("sha512", $requestObject->currentProfilePassword, $profile->getProfileSalt(), 262144);
				if($currentPasswordHash !== $profile->getProfilePasswordHash()) {
					throw(new \RuntimeException("Old password is incorrect", 401));
				}

				$newPasswordSalt = bin2hex(random_bytes(16));
				$newPasswordHash = hash_pbkdf2("sha512", $requestObject->newProfilePassword, $newPasswordSalt, 262144);
				$profile->setProfilePasswordHash($newPasswordHash);
				$profile->setProfileSalt($newPasswordSalt);
			}

			$profile->update($pdo);
		} else if($method === "POST"){

			//create new profile and insert into database
			$profile = new Profile(null, $requestObject->profileImageId, $requestObject->profileActivation, $requestObject->profileEmail, $requestObject->profileHandle, null, $requestObject->profileName, $requestObject->profilePasswordHash, $requestObject->profileSalt, $requestObject->profileSummary);
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