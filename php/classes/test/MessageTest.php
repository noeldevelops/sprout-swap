<?php
namespace Edu\Cnm\SproutSwap\Test;

//grab the project test
use Edu\Cnm\SproutSwap\{Profile, Message, Image, Point, Mode, Post};

require_once("SproutSwapTest.php");

//grab the Message class
require_once(dirname(__DIR__) . "/autoload.php");

class MessageTest extends SproutSwapTest{
	protected $VALID_MESSAGEPOSTID = 111111;
	protected $VALID_MESSAGERECEIVERPROFILEID = null;
	protected $VALID_MESSAGESENDERPROFILEID = null;
	protected $VALID_MESSAGEBROWSER = "Message browser passing";
	protected $VALID_MESSAGECONTENT = "Message content passing";
	protected $VALID_MESSAGECONTENT2 = "Message updated content passing";
	protected $VALID_MESSAGEIPADDRESS = "2600::dead:beef:cafe";
	protected $VALID_MESSAGESTATUS = 1;
	protected $VALID_MESSAGETIMESTAMP = null;
	protected $VALID_MODE = null;
	protected $VALID_LAT = 45.43;
	protected $VALID_LONG = 90.432;
	private $image = null;
	/**
	 * @var Profile $receiverProfile
	 */
	private $receiverProfile = null;
	/**
	 * @var Profile $senderProfile
	 */
	private $senderProfile = null;
	/**
	 * @var Post $post
	 */
	private $post = null;
	/**
	 * @var Point $newPoint
	 */
	private $newPoint = null;
	/**
	 * valid profile hash
	 * @var null $VALID_PROFILEHASH
	 **/
	protected $VALID_PROFILEHASH = null;
	/**
	 * valid profile salt
	 * @var null $VALID_PROFILESALT
	 **/
	protected $VALID_PROFILESALT = null;
	/**
	 * set up for test
	 * creating dependent objects before running the test
	 */
	public final function setUp(){
		parent::setUp();
		$this->image = new Image(null, "sjnghsklguenghtls");
		$this->image->insert($this->getPDO());

		$this->newPoint = new Point($this->VALID_LAT, $this->VALID_LONG);

		$this->VALID_MESSAGETIMESTAMP = new \DateTime();

		//creating salt and hash
		$password = "123";
		$this->VALID_PROFILESALT = bin2hex(random_bytes(32));
		$this->VALID_PROFILEHASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILESALT, 262144);

		$this->receiverProfile = new Profile(null, $this->image->getImageId(), "kjsdhkj", "solomon.leyba@gmail.com", "2600::dead:beef:cafe", $this->VALID_MESSAGETIMESTAMP, "Solomon Leyba",$this->VALID_PROFILEHASH, $this->VALID_PROFILESALT, "we do THE BEST unit tests, tremmendous");
		$this->receiverProfile->insert($this->getPDO());

		$this->senderProfile = new Profile(null, $this->image->getImageId(), "sdfsd", "djt@america.gov", "2600::dead:beef:cafe", $this->VALID_MESSAGETIMESTAMP, "Noel Cothren",$this->VALID_PROFILEHASH, $this->VALID_PROFILESALT, "god damn i STILL love unit testing");
		$this->senderProfile->insert($this->getPDO());

		$this->VALID_MODE = new Mode(null, "Free");
		$this->VALID_MODE->insert($this->getPDO());

		$this->post = new Post(null, $this->VALID_MODE->getModeId(), $this->receiverProfile->getProfileId(), "browser here or something", "post content here or something", $this->VALID_MESSAGEIPADDRESS, $this->newPoint, "vegetables", "different veggies tbh", $this->VALID_MESSAGETIMESTAMP);
		$this->post->insert($this->getPDO());
	}

	/**
	 *
	 */
	public function testInsertValidMessage(){
		//store number of current rows to compare against
		$numRows = $this->getConnection()->getRowCount("message");
		//create new message and insert
		$message = new Message(null, null, $this->receiverProfile->getProfileId(), $this->senderProfile->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
		$message->insert($this->getPDO());
		// enforce fields match expectation
		$pdoMessage = Message::getMessageByMessageId($this->getPDO(), $message->getMessageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertEquals($pdoMessage->getMessageId(), $message->getMessageId());
		$this->assertEquals($pdoMessage->getMessageReceiverProfileId(), $this->receiverProfile->getProfileId());
		$this->assertEquals($pdoMessage->getMessageSenderProfileId(), $this->senderProfile->getProfileId());
		$this->assertEquals($pdoMessage->getMessageBrowser(), $this->VALID_MESSAGEBROWSER);
		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageIpAddress(), inet_pton($this->VALID_MESSAGEIPADDRESS));
		$this->assertEquals($pdoMessage->getMessageStatus(), $this->VALID_MESSAGESTATUS);
		$this->assertEquals($pdoMessage->getMessageTimestamp(), $this->VALID_MESSAGETIMESTAMP);
	}
	/**
	 * test insert invalid message
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidMessage(){
		//create a message w non-null message id
		$message = new Message(SproutSwapTest::INVALID_KEY, null, $this->receiverProfile->getProfileId(), $this->senderProfile->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
		$message->insert($this->getPDO());
	}
	/**
	 * testing deleting a valid message
	 *
	 */
	public function testDeleteValidMessage(){
		//store number of current rows to compare against
		$numRows = $this->getConnection()->getRowCount("message");
		//create new message and insert
		$message = new Message(null, null, $this->receiverProfile->getProfileId(), $this->senderProfile->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
		$message->insert($this->getPDO());
		//delete message from mySQL
		$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("message"));
		$message->delete($this->getPDO());
		//grab mySQL data and ensure message does not exist
		$pdoMessage = Message::getMessageByMessageId($this->getPDO(), $message->getMessageId());
		$this->assertNull($pdoMessage);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("message"));
	}
	/**
	 * test invalid delete; message has not even been inserted!!
	 * @expectedException \PDOException
	 */
	public function testDeleteInvalidMessage(){
		$message = new Message(null, null, $this->receiverProfile->getProfileId(), $this->senderProfile->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
		$message->delete($this->getPDO());
	}
	/**
	 * testing getting a valid message from sender profile Id
	 */
	public function testGetValidMessageByMessageSenderProfileId() {
		//store number of current rows to compare against
		$numRows = $this->getConnection()->getRowCount("message");
		//create new message and insert
		$message = new Message(null, null, $this->receiverProfile->getProfileId(), $this->senderProfile->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
		$message->insert($this->getPDO());
		//grab data from mySQL to check against expected
		$results = Message::getMessageByMessageSenderProfileId($this->getPDO(), $message->getMessageSenderProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Message", $results);
		//grab result from array and validate
		$pdoMessage = $results[0];
		$this->assertEquals($pdoMessage->getMessageId(), $message->getMessageId());
		$this->assertEquals($pdoMessage->getMessageReceiverProfileId(), $this->receiverProfile->getProfileId());
		$this->assertEquals($pdoMessage->getMessageSenderProfileId(), $this->senderProfile->getProfileId());
		$this->assertEquals($pdoMessage->getMessageBrowser(), $this->VALID_MESSAGEBROWSER);
		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageIpAddress(), inet_pton($this->VALID_MESSAGEIPADDRESS));
		$this->assertEquals($pdoMessage->getMessageStatus(), $this->VALID_MESSAGESTATUS);
		$this->assertEquals($pdoMessage->getMessageTimestamp(), $this->VALID_MESSAGETIMESTAMP);
	}
	/**
	 * testing searching for an invalid message based on sender profile id
	 */
	public function testGetInvalidMessageByMessageSenderProfileId(){
		$message = Message::getMessageByMessageSenderProfileId($this->getPDO(), $this->senderProfile->getProfileId());
		$this->assertCount(0, $message);
	}

	/**
	 * testing searching for a valid message based on receiver profile id
	 */
	public function testGetValidMessageByMessageReceiverProfileId() {
		//store number of current rows to compare against
		$numRows = $this->getConnection()->getRowCount("message");
		//create new message and insert
		$message = new Message(null, null, $this->receiverProfile->getProfileId(), $this->senderProfile->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
		$message->insert($this->getPDO());
		//grab data from mySQL to check against expected
		$results = Message::getMessageByMessageReceiverProfileId($this->getPDO(), $message->getMessageReceiverProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Message", $results);
		//grab result from array and validate
		$pdoMessage = $results[0];
		$this->assertEquals($pdoMessage->getMessageId(),  $message->getMessageId());
		$this->assertEquals($pdoMessage->getMessageReceiverProfileId(), $this->receiverProfile->getProfileId());
		$this->assertEquals($pdoMessage->getMessageSenderProfileId(), $this->senderProfile->getProfileId());
		$this->assertEquals($pdoMessage->getMessageBrowser(), $this->VALID_MESSAGEBROWSER);
		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageIpAddress(), inet_pton($this->VALID_MESSAGEIPADDRESS));
		$this->assertEquals($pdoMessage->getMessageStatus(), $this->VALID_MESSAGESTATUS);
		$this->assertEquals($pdoMessage->getMessageTimestamp(), $this->VALID_MESSAGETIMESTAMP);
	}

	/**
	 * testing searching for an invalid message based on receiver profile id
	 */
	public function testGetInvalidMessagesByMessageReceiverProfileId(){
		$message = Message::getMessageByMessageReceiverProfileId($this->getPDO(), $this->receiverProfile->getProfileId());
		$this->assertCount(0, $message);
	}
	/**
	 * test grabbing valid messages based on post id
	 */
	public function testGetValidMessagesByMessagePostId(){
		//store number of current rows to compare against
		$numRows = $this->getConnection()->getRowCount("message");
		//create new message and insert
		$message = new Message(null, $this->post->getPostId(), $this->receiverProfile->getProfileId(), $this->senderProfile->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
		$message->insert($this->getPDO());
		//grab data from mySQL to check against expected
		$results = Message::getMessagesByMessagePostId($this->getPDO(), $message->getMessagePostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Message", $results);
		//grab result from array and validate
		$pdoMessage = $results[0];
		$this->assertEquals($pdoMessage->getMessageId(), $message->getMessageId());
		$this->assertEquals($pdoMessage->getMessageReceiverProfileId(), $this->receiverProfile->getProfileId());
		$this->assertEquals($pdoMessage->getMessageSenderProfileId(), $this->senderProfile->getProfileId());
		$this->assertEquals($pdoMessage->getMessageBrowser(), $this->VALID_MESSAGEBROWSER);
		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageIpAddress(), inet_pton($this->VALID_MESSAGEIPADDRESS));
		$this->assertEquals($pdoMessage->getMessageStatus(), $this->VALID_MESSAGESTATUS);
		$this->assertEquals($pdoMessage->getMessageTimestamp(), $this->VALID_MESSAGETIMESTAMP);
	}
	/**
	 * test grabbing invalid message based on message post id
	 * @expectedException \PDOException
	 */
	public function testGetInvalidMessagesByMessagePostId(){
		$message = new Message(SproutSwapTest::INVALID_KEY, $this->VALID_MESSAGEPOSTID, $this->receiverProfile->getProfileId(), $this->senderProfile->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
		$message->insert($this->getPDO());
		$results = Message::getMessagesByMessagePostId($this->getPDO(), $message->getMessagePostId());
		$this->assertCount(0, $results);
	}
	/**
	 * testing grabbing a valid message based on message content
	 */
	public function testGetValidMessageByMessageContent(){
		//store number of current rows to compare against
		$numRows = $this->getConnection()->getRowCount("message");
		//create new message and insert
		$message = new Message(null, null, $this->receiverProfile->getProfileId(), $this->senderProfile->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
		$message->insert($this->getPDO());
		// grab mySQL data and enforce it matches expectations
		$results = Message::getMessageByMessageContent($this->getPDO(), $message->getMessageContent());
		$this->assertCount(1, $results);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Message", $results);
		//grab array result and verify
		$pdoMessage = $results[0];
		$this->assertEquals($pdoMessage->getMessageId(),  $message->getMessageId());
		$this->assertEquals($pdoMessage->getMessageReceiverProfileId(), $this->receiverProfile->getProfileId());
		$this->assertEquals($pdoMessage->getMessageSenderProfileId(), $this->senderProfile->getProfileId());
		$this->assertEquals($pdoMessage->getMessageBrowser(), $this->VALID_MESSAGEBROWSER);
		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageIpAddress(), inet_pton($this->VALID_MESSAGEIPADDRESS));
		$this->assertEquals($pdoMessage->getMessageStatus(), $this->VALID_MESSAGESTATUS);
		$this->assertEquals($pdoMessage->getMessageTimestamp(), $this->VALID_MESSAGETIMESTAMP);
	}
	/**
	 * testing grabbing invalid message based on message content
	 */
	public function testGetInvalidMessageByMessageContent(){
		$message = Message::getMessageByMessageContent($this->getPDO(), "nothing b");
		$this->assertCount(0, $message);
	}
	/**
	 * testing grabbing a valid message based on message id
	 */
	public function testGetValidMessageByMessageId(){
		//store number of current rows to compare against
		$numRows = $this->getConnection()->getRowCount("message");
		//create new message and insert
		$message = new Message(null, null, $this->receiverProfile->getProfileId(), $this->senderProfile->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
		$message->insert($this->getPDO());
		//grab and validate
		$pdoMessage = Message::getMessageByMessageId($this->getPDO(), $message->getMessageId());
		$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("message"));
		$this->assertEquals($pdoMessage->getMessageId(),  $message->getMessageId());
		$this->assertEquals($pdoMessage->getMessageReceiverProfileId(), $this->receiverProfile->getProfileId());
		$this->assertEquals($pdoMessage->getMessageSenderProfileId(), $this->senderProfile->getProfileId());
		$this->assertEquals($pdoMessage->getMessageBrowser(), $this->VALID_MESSAGEBROWSER);
		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageIpAddress(), inet_pton($this->VALID_MESSAGEIPADDRESS));
		$this->assertEquals($pdoMessage->getMessageStatus(), $this->VALID_MESSAGESTATUS);
		$this->assertEquals($pdoMessage->getMessageTimestamp(), $this->VALID_MESSAGETIMESTAMP);
	}
	/**
	 * testing grabbing a non-existent message based on message id
	 */
	public function testGetInvalidMessageByMessageId(){
		$message = Message::getMessageByMessageId($this->getPDO(), SproutSwapTest::INVALID_KEY);
		$this->assertNull($message);
	}
}