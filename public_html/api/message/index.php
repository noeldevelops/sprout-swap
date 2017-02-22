<?php

require_once dirname(__DIR__,3)."/php/classes/autoload.php";
require_once dirname(__DIR__,3)."/lib/xsrf.php";
require_once "/etc/apache2/capstone-mysql/encrypted-config.php";

use Edu\Cnm\SproutSwap\Message;

/**
 * API for Message class
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

try{
	//grab mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/message.ini");

	//determines which HTTP method needs to be processed and stores it in $method
	$method = array_key_exists("HTTP_x_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//stores primary key for the GET, DELETE, and PUT methods in $id
	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$senderId = filter_input(INPUT_GET, "senderId", FILTER_VALIDATE_INT);
	$receiverId = filter_input(INPUT_GET, "receiverId", FILTER_VALIDATE_INT);
	$postId = filter_input(INPUT_GET, "postId", FILTER_VALIDATE_INT);
	$content = filter_input(INPUT_GET, "content", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure id is valid for methods that require it
	if(($method ==="DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)){
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	//handle GET requests - if id is present that message is return otherwise all message are returned
	if($method === "GET"){

		//set XSRF cookie
		setXsrfCookie();

		//get a specific message or all messages and update reply
		if(empty($id) === false){
			$message = Message::getMessageByMessageId($pdo, $id);
			if($message !== null){
				$reply->data = $message;
			}
		}
	}
}




















