<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\SproutSwap\Image;
use Edu\Cnm\SproutSwap\Point;

$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/sprout-swap.ini");

$postModeId = filter_input(INPUT_POST, "postModeId", FILTER_VALIDATE_INT);
$postContent = filter_input(INPUT_POST, "postContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
$postLocationLat = filter_input(INPUT_POST, "postLocationLat", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$postLocationLng = filter_input(INPUT_POST, "postLocationLng", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$postOffer = filter_input(INPUT_POST, "postOffer", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
$postRequest = filter_input(INPUT_POST, "postRequest", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

/** Cloudinary API stuff**/
$config = readConfig("/etc/apache2/capstone-mysql/sprout-swap.ini");
$cloudinary = json_decode($config["cloudinary"]);
\Cloudinary::config(["cloud_name" => $cloudinary->cloudName, "api_key" => $cloudinary->apiKey, "api_secret" => $cloudinary->apiSecret]);

$tempUserFileName = $_FILES["file"]["tmp_name"];
$userFileType = $_FILES["file"]["type"];
$userFileExtension = strtolower(strrchr($_FILES["file"]["name"], "."));

//upload image to cloudinary and get public id
$cloudinaryResult = \Cloudinary\Uploader::upload($_FILES["file"]["tmp_name"], array("width"=>500, "crop"=>"scale"));

//after sending the image to Cloudinary, grab the public id and create a new image
$image = new Image(null, $cloudinaryResult["public_id"]);
$image->insert($pdo);

if(empty($_SESSION["profile"]->getProfileId() ) === true) {
	throw(new \InvalidArgumentException("You are not allowed to make a post unless you're logged in.", 401));
}

if(empty($requestObject->postImagePostId !== true) && empty($requestObject->postImageImageId !== true)) {
	$postImage = new PostImage($requestObject->postImageImageId, $requestObject->postImagePostId);
	$postImage->insert($pdo);
}

//create a new post and insert into database
$post = new Post(null, $postModeId, $_SESSION["profile"]->getProfileId(), $_SERVER["HTTP_USER_AGENT"], $postContent, $_SERVER["REMOTE_ADDR"], $postLocation = new Point ($postLocationLat, $postLocationLng), $postOffer, $postRequest, null);
$post->insert($pdo);