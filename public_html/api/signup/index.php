<?php

require_once (dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once (dirname(__DIR__, 3) . "/php/lib/mailgun.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\SproutSwap\Profile;

/**
 * api for signup
 *
 * @author Zak Abad <abad.zacaria@gmail.com>; adapted from project flek
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

	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER
	["REQUEST_METHOD"];
	$reply->method = $method;

	//perform the post

	if($method === "POST") {
		//verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//ensure all required information is entered

		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException("Must fill in email address."));
		}
		if(empty($requestObject->profileHandle) === true) {
			throw(new \InvalidArgumentException("Must fill in Handle"));
		}
		if(empty($requestObject->profileName) === true) {
			throw(new \InvalidArgumentException("Must fill in Name."));
		}
		if(empty($requestObject->profilePassword) === true) {
			throw(new \InvalidArgumentException("Must fill in password."));
		} else {
			$profilePassword = $requestObject->profilePassword;
		}
		if(empty($requestObject->profileConfirmPassword) === true) {
			throw(new \InvalidArgumentException("Please confirm the password."));
		}
		if($requestObject->profilePassword !== $requestObject->profileConfirmPassword) {
			throw(new \InvalidArgumentException("Password does not match."));
		}

		$salt = bin2hex(random_bytes(32));
		$hash = hash_pbkdf2("sha512", $profilePassword, $salt, 262144);
		$profileActivationToken = bin2hex(random_bytes(16));

		//create a new profile

		$profile = new Profile(null,$requestObject->profileImageId=null, $profileActivationToken, $requestObject->profileEmail, $requestObject->profileHandle, null, $requestObject->profileName, $hash, $salt, $requestObject->profileSummary);
		$profile->insert($pdo);

//building the activation link that can travel to another server and still work. This is the link that will be clicked to confirm the account.

		$basePath = dirname($_SERVER["SCRIPT_NAME"], 2);
		$urlglue = $basePath . "/activation/?profileActivation=$profileActivationToken";
		$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;
		$messageSubject = "Sprout-Swap Account Activation";
		$message = <<< EOF
<h2>Welcome to Sprout-Swap!</h2>
<p>Please visit the following URL to set a new password and complete the sign-up process: </p><p><a href="$confirmLink">$confirmLink<a></p>
EOF;
		$response = mailGunslinger("Sprout-Swap", "sproutswap.team@gmail.com", $requestObject->profileName, $requestObject->profileEmail, $messageSubject, $message);

		$reply->message = "Almost done! Please check your email to activate your account.";
	} else {
		throw(new \InvalidArgumentException("Invalid HTTP request.", 405));
	}
} catch(\Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(\TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
header("Content-type: application/json");
echo json_encode($reply);