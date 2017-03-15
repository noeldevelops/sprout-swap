<?php

require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\SproutSwap\{
	Post, Point, PostImage
};

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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/sprout-swap.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$postModeId = filter_input(INPUT_GET, "postModeId", FILTER_VALIDATE_INT);
	$postProfileId = filter_input(INPUT_GET, "postProfileId", FILTER_VALIDATE_INT);
	$postContent = filter_input(INPUT_GET, "postContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$postLocationLat = filter_input(INPUT_GET, "postLocationLat", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$postLocationLng = filter_input(INPUT_GET, "postLocationLng", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$postOffer = filter_input(INPUT_GET, "postOffer", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$postRequest = filter_input(INPUT_GET, "postRequest", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$postSunriseDate = filter_input(INPUT_GET, "postSunriseDate", FILTER_VALIDATE_INT);
	$postSunsetDate = filter_input(INPUT_GET, "postSunsetDate", FILTER_VALIDATE_INT);
	$postTimestamp = filter_input(INPUT_GET, "postTimestamp", FILTER_VALIDATE_INT);
	$userLocationX = filter_input(INPUT_GET, "userLocationX", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$userLocationY = filter_input(INPUT_GET, "userLocationY", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$userDistance = filter_input(INPUT_GET, "userDistance", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);


	// searching by location? get to the point!
	$postLocation = null;
	if(empty($postLocationLat) === false && empty($postLocationLng) === false) {
		$postLocation = new Point($postLocationLat, $postLocationLng);
	}

	if(empty($postSunriseDate) === false && empty($postSunsetDate) === false) {
		$postSunriseDate = \DateTime::createFromFormat("U", $postSunriseDate / 1000);
		$postSunsetDate = \DateTime::createFromFormat("U", $postSunsetDate / 1000);
	}

	//make sure the postId is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	//handle GET requests
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		if(empty($id) === false) {
			$post = Post::getPostByPostId($pdo, $id);
			if($post !== null) {
				$reply->data = $post;
			}
		} elseif(empty($postModeId) === false) {
			$posts = Post::getPostsByPostModeId($pdo, $postModeId)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}
		} elseif(empty($postProfileId) === false) {
			$posts = Post::getPostsByPostProfileId($pdo, $postProfileId)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}
		} elseif(empty($postContent) === false) {
			$posts = Post::getPostsByPostContent($pdo, $postContent)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}
		} elseif(empty($postLocation) === false) {
			$posts = Post::getPostsByPostLocation($pdo, new Point($userLocationX, $userLocationY), $userDistance)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}
		} elseif(empty($postOffer) === false) {
			$posts = Post::getPostsByPostOffer($pdo, $postOffer)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}
		} elseif(empty($postRequest) === false) {
			$posts = Post::getPostsByPostRequest($pdo, $postRequest)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}
		} elseif(empty($postTimestamp) === false) {
			$posts = Post::getPostsByPostTimestamp($pdo, $postSunriseDate, $postSunsetDate)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}
		}

	} elseif($method === "PUT" || $method === "POST") {

		verifyXsrf();
		
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		//take the lat and long in postLocation and make it a new Point
		$postLocation = new Point($requestObject->postLocation->pointLat, $requestObject->postLocation->pointLong);

//		//make sure postProfileId is available
//		if(empty($requestObject->postProfileId) === true) {
//			throw(new \InvalidArgumentException("No profile ID for Post", 405));
//		}
		//make sure modeId is available
		if(empty($requestObject->postModeId) === true) {
			throw(new \InvalidArgumentException("No Mode available", 405));
		}

		if(empty($requestObject->postLocation) === true) {
			throw (new \InvalidArgumentException("No location?!", 405));
		}

		if(empty($requestObject->postOffer) === true) {
			throw (new \InvalidArgumentException("No offer for post", 405));
		}

//		if(empty($requestObject->postImageId) === true) {
//			throw (new \InvalidArgumentException("No image for post", 405));
//		}


		if($method === "PUT") {
			//retrieve the post
			$post = Post::getPostByPostId($pdo, $id);



			if($post === null) {
				throw(new RuntimeException("Post does not exist", 404));
			}
			if(empty($_SESSION["profile"]) === true || ($_SESSION["profile"]->getProfileId() !== $post->getPostProfileId())) {
				throw(new \InvalidArgumentException("You are not allowed to update this post.", 401));
			}
			//update all attributes

			$post->setPostModeId($requestObject->postModeId);
			$post->setPostContent($requestObject->postContent);
			$post->setPostLocation($postLocation);
			$post->setPostOffer($requestObject->postOffer);
			$post->setPostRequest($requestObject->postRequest);


			$post->update($pdo);

			//update reply
			$reply->message = "Post was successfully updated";

		} elseif($method === "POST") {

			if(empty($_SESSION["profile"]->getProfileId() ) === true) {
				throw(new \InvalidArgumentException("You are not allowed to make a post unless you're logged in.", 401));
			}

			if(empty($requestObject->postImagePostId !== true) && empty($requestObject->postImageImageId !== true)) {
				$postImage = new PostImage($requestObject->postImageImageId, $requestObject->postImagePostId);
				$postImage->insert($pdo);
				$reply->data = $postImage;
				var_dump($postImage);
				return;
			}


			//create a new post and insert into database
			$post = new Post(null, $requestObject->postModeId, $_SESSION["profile"]->getProfileId(), $_SERVER["HTTP_USER_AGENT"], $requestObject->postContent, $_SERVER["REMOTE_ADDR"], $postLocation, $requestObject->postOffer, $requestObject->postRequest, null);
			$post->insert($pdo);

			//update reply
			$reply->data = $post->getPostId();
			$reply->message = "New post successful.";
		}

	} elseif($method === "DELETE") {
		verifyXsrf();

		//retrieve the post to be deleted
		$post = Post::getPostByPostId($pdo, $id);
		if($post === null) {
			throw(new RuntimeException("Post does not exist", 404));
		}
		if(empty($_SESSION["profile"]) === true || ($_SESSION["profile"]->getProfileId() !== $post->getPostProfileId())) {
			throw(new \InvalidArgumentException("You are not allowed to delete this post.", 401));
		}
		//delete the post
		$post->delete($pdo);

		//update reply
		$reply->message = "Post was deleted.";

	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request"));
	}

//update reply with exception information

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

//encode and return reply to front end caller
echo json_encode($reply);