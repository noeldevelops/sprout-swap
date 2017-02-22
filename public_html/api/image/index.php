<?php

require_once dirname(__DIR__,3)."/php/classes/autoload.php";
require_once dirname(__DIR__, 3)."/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\SproutSwap\Image;

//require 'Cloudinary.php';
//require 'Uploader.php';
//require 'Api.php';

/**
 * api for the Image class
 *
 * @author Noel Cothren <noelcothren@gmail.com>
 **/

//verify the session, start if inactive
if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/sprout-swap.ini");

	/** @todo insert cloudinary stuff here **/

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$imageId = filter_input(INPUT_GET, "imageId", FILTER_VALIDATE_INT);
	$imageCloudinaryId = filter_input(INPUT_GET, "imageCloudinaryId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($imageId) === true || $imageId < 0)) {
		throw (new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	//handle GET request
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific post or all posts and update reply
		if(empty($imageId) === false) {
			$image = Image::getImageByImageId($pdo, $imageId);
			if($image !== null) {
				$reply->data = $image;
			}
		} elseif(empty($imageCloudinaryId) === false) {
			$image = Image::getImageByImageCloudinaryId($pdo, $imageCloudinaryId);
			if($image !== null) {
				$reply->data = $image;
			}
		}
	} elseif($method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure image cloudinary ID is available
		if(empty($requestObject->imageCloudinaryId) === true) {
			throw(new \InvalidArgumentException("No image cloudinary ID", 405));
		}
		if($method === "POST") {

			$image = new Image(null, $requestObject->imageCloudinaryId);
			$image->insert($pdo);

			$reply->message = "Image created ok";
		}
	} elseif($method === "DELETE") {
		verifyXsrf();

		//retrieve the image to be deleted
		$image = Image::getImageByImageId($pdo, $imageId);
		if($image === null) {
			throw(new RuntimeException("Image does not exist", 404));
		}
		$image->delete($pdo);

		$reply->message = "Image successfully deleted.";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request"));
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