<?php

require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once "/etc/apache2/capstone-mysql/encrypted-config.php";

use Edu\Cnm\SproutSwap\Message;

/**
 * API for Message class
 *
 * @author Solomon Leyba <solomon.leyba@gmail.com>
 */

//check session status; if not active then starts the session
if(session_status() !== PHP_SESSION_ACTIVE) {
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
	$messageId = filter_input(INPUT_GET, "messageId", FILTER_VALIDATE_INT);
	$messagePostId = filter_input(INPUT_GET, "messagePostId", FILTER_VALIDATE_INT);
	$messageReceiverProfileId = filter_input(INPUT_GET, "messageReceiverProfileId", FILTER_VALIDATE_INT);
	$messageSenderProfileId = filter_input(INPUT_GET, "messageSenderProfileId", FILTER_VALIDATE_INT);
	$messageContent = filter_input(INPUT_GET, "messageContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure id is valid for methods that require it
	if(($method === "DELETE") && (empty($messageId) === true || $messageId < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	//handle GET requests - if id is present that message is return otherwise all message are returned
	if($method === "GET") {

		//set XSRF cookie
		setXsrfCookie();

		//get a specific message or all messages and update reply
		if(empty($messageId) === false) {
			$message = Message::getMessageByMessageId($pdo, $messageId);
			if($message !== null) {
				$reply->data = $message;
			}
		} else if(empty($messageReceiverProfileId) === false) {
			$messages = Message::getMessageByMessageReceiverProfileId($pdo, $messageReceiverProfileId)->toArray();
			if($messages !== null) {
				$reply->data = $messages;
			}
		} else if(empty($messageSenderProfileId) === false) {
			$messages = Message::getMessageByMessageSenderProfileId($pdo, $messageSenderProfileId)->toArray();
			if($messages !== null) {
				$reply->data = $messages;
			}
		} else if(empty($messagePostId) === false) {
			$messages = Message::getMessagesByMessagePostId($pdo, $messagePostId)->toArray();
			if($messages !== null) {
				$reply->data = $messages;
			}
		} else if(empty($messageContent) === false) {
			$messages = Message::getMessageByMessageContent($pdo, $messageContent)->toArray();
			if($messages !== null) {
				$reply->data = $messages;
			}
		}
	} else if($method === "PUT" || $method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure message content is available
		if(empty($requestObject->messageContent) === true) {
			throw(new \InvalidArgumentException("No message content", 405));
		}
		if(empty($requestObject->messageSenderId) === true) {
			throw(new \InvalidArgumentException("Message sender does not exist", 405));
		}
		//make sure messageReceiverId is available
		if(empty($requestObject->messageReceiverId) === true) {
			throw(new \InvalidArgumentException("Message receiver does not exist", 405));
		}

		//perform the actual POST; there is no PUT method since messages cannot be updated
		//create new message and insert into the database
		//TODO: enforce the session profile matches the sender profile id
//		if($_SESSION["profile"]->getProfileId() !== $requestObject->getMessageSenderProfileId()) {
//			throw(new \InvalidArgumentException("Session profile id does not match message sender id", 403));
//		}
		if($method === "POST") {
			$message = new Message(null, $requestObject->messagePostId, $requestObject->messageReceiverId, $requestObject->messageSenderId, $_SERVER["HTTP_USER_AGENT"], $requestObject->messageContent, $_SERVER["REMOTE_ADDR"], $requestObject->messageStatus, null);
			$message->insert($pdo);

			//update reply
			$reply->message = "Message created ok";
		} else if($method === "PUT") {
			$message = Message::getMessageByMessageId($pdo, $messageId);
			if($message === null) {
				throw(new RuntimeException("Message does not exist", 404));
			}

			//update message status
			$message->setMessageStatus($requestObject->messageStatus);
			$message->update($pdo);
		} else if($method === "DELETE") {
			verifyXsrf();

			//retrieve message to be deleted
			//TODO: enforce the session profile matches the sender profile id

			$message = Message::getMessageByMessageId($pdo, $messageId);
			if($message === null) {
				throw(new RuntimeException("Message does not exist", 404));
			}

			//delete message
			$message->delete($pdo);

			//update reply
			$reply->message = "Tweet deleted ok";
		}
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

header("content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

//encode and return to front end caller
echo json_encode($reply);