<?php

require_once dirname(__DIR__,3)."/php/classes/autoload.php";
require_once dirname(__DIR__, 3)."/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\SproutSwap\Post;

/**
 * api for Post class
 *
 * @author Noel Cothren <noelcothren@gmail.com>
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
	//grab mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/post.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$postId = filter_input(INPUT_GET, "postId", FILTER_VALIDATE_INT);
	$postModeId = filter_input(INPUT_GET, "postModeId", FILTER_VALIDATE_INT);
	$postProfileId = filter_input(INPUT_GET, "postProfileId", FILTER_VALIDATE_INT);
	$postContent = filter_input(INPUT_GET, "postContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$postLocation = filter_input(INPUT_GET, "postLocation", FILTER_VALIDATE_POINT);
	$postOffer = filter_input(INPUT_GET, "postOffer", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$postRequest = filter_input(INPUT_GET, "postRequest", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$postTimestamp = filter_input(INPUT_GET, "postTimestamp", FILTER_VALIDATE_DATETIME);

	//make sure the postId is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($postId) === true || $postId < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	//handle GET requests
if ($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		if(empty($postId) === false) {
			$post = Post::getPostByPostId($pdo, $postId);
			if($post !== null) {
				$reply->data = $post;
			}
		} elseif(empty($postModeId) === false) {
			$posts = Post::getPostsByPostModeId($pdo, $postModeId);
			if($posts !== null) {
				$reply->data = $posts;
			}
		} elseif(empty($postProfileId) === false) {
			$posts = Post::getPostsByPostProfileId($pdo, $postProfileId);
			if($posts !== null) {
				$reply->data = $posts;
			}
		} elseif(empty($postContent) === false) {
			$posts = Post::getPostsByPostContent($pdo, $postContent);
			if($posts !== null) {
				$reply->data = $posts;
			}
		} /** @todo figure out what variables go here! **/
		elseif(empty($postLocation) === false) {
			$posts = Post::getPostsByPostLocation($pdo, $postLocation);
			if($posts !== null) {
				$reply->data = $posts;
			}
		} elseif(empty($postOffer) === false) {
			$posts = Post::getPostsByPostOffer($pdo, $postOffer);
			if($posts !== null) {
				$reply->data = $posts;
			}
		} elseif(empty($postRequest) === false) {
			$posts = Post::getPostsByPostRequest($pdo, $postRequest);
			if($posts !== null) {
				$reply->data = $posts;
			}
		} /** @todo figure out what goes here! **/
		elseif(empty($postTimestamp) === false) {
			$posts = Post::getPostsByPostTimestamp($pdo, $postTimestamp);
			if($posts !== null) {
				$reply->data = $posts;
			}
		}

} elseif($method === "PUT" || $method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

	/** @todo figure out what goes here! one statement for each attribute?
	 * **/
	//make sure post content is available <-Dylan's note
	if(empty($requestObject->postContent)==true) {
		throw(new \InvalidArgumentException("No content for Post", 405));
	}

	if($method === "PUT") {

	} elseif($method === "POST") {

	}
} elseif($method === "DELETE") {

}
} catch