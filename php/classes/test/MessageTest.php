<?PHP
namespace Edu\Cnm\SproutSwap\Test;

//grab the project test
use Edu\Cnm\SproutSwap\{Profile, Message, Image};

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
	private $image = null;
	private $receiverProfile = null;
	private $senderProfile = null;

	/**
	 * set up for test
	 * creating dependent objects before running the test
	 */
	public final function setUp(){
		parent::setUp();
		$this->image = new Image(null, "sjnghsklguenghtls");
		$this->image->insert($this->getPDO());
		$this->VALID_MESSAGETIMESTAMP = new \DateTime();
		$this->receiverProfile = new Profile(null, $this->image->getImageId(), "kjsdhkj", "solomon.leyba@gmail.com", "2600::dead:beef:cafe", $this->VALID_MESSAGETIMESTAMP, "Solomon Leyba", "803AE81D0D6F67C1C0D307B39A99A93F6B6499B4C6E3F2ECE96718C5E2724B96", "5A929D9C14C5DF68BD2C97BBE2652754E26B3C9D23AC91978A0B9C0EAA3DE347", "we do THE BEST unit tests, tremmendous");
		$this->receiverProfile->insert($this->getPDO());
		$this->senderProfile = new Profile(null, $this->image->getImageId(), "sdfsd", "djt@america.gov", "2600::dead:beef:cafe", $this->VALID_MESSAGETIMESTAMP, "Noel Cothren", "9BB789D2052F1E787C89A700A59EF22DE1AFAEACC0E2DE97D22DC1D04284E871", "4C703B281FB196C94B61CC075B1F3191A0D9A4CEE2A46E153449728D3EC18503", "god damn i STILL love unit testing");
		$this->senderProfile->insert($this->getPDO());
	}
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
		$this->assertEquals($pdoMessage->getMessageTimestamp(), $message->getMessageTimestamp());
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
		$message = new Message(SproutSwapTest::INVALID_KEY, null, $this->receiverProfile->getProfileId(), $this->senderProfile->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
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
		$this->assertEquals($pdoMessage->getMessageTimestamp(), $message->getMessageTimestamp());
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
		$this->assertEquals($pdoMessage->getMessageTimestamp(), $message->getMessageTimestamp());
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
		$message = new Message(null, $this->VALID_MESSAGEPOSTID, $this->receiverProfile->getProfileId(), $this->senderProfile->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
		$message->insert($this->getPDO());
		//grab data from mySQL to check against expected
		$results = Message::getMessagesByMessagePostId($this->getPDO(), $message->getMessagePostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Message", $results);
		var_dump($results);
		//grab result from array and validate
		$pdoMessage = $results[0];
		$this->assertEquals($pdoMessage->getMessageId(), $message->getMessageId());
		$this->assertEquals($pdoMessage->getMessageReceiverProfileId(), $this->receiverProfile->getProfileId());
		$this->assertEquals($pdoMessage->getMessageSenderProfileId(), $this->senderProfile->getProfileId());
		$this->assertEquals($pdoMessage->getMessageBrowser(), $this->VALID_MESSAGEBROWSER);
		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageIpAddress(), inet_pton($this->VALID_MESSAGEIPADDRESS));
		$this->assertEquals($pdoMessage->getMessageStatus(), $this->VALID_MESSAGESTATUS);
		$this->assertEquals($pdoMessage->getMessageTimestamp(), $message->getMessageTimestamp());
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
		$this->assertEquals($pdoMessage->getMessageTimestamp(), $message->getMessageTimestamp());
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
		$this->assertEquals($pdoMessage->getMessageTimestamp(), $message->getMessageTimestamp());
	}
	/**
	 * testing grabbing a non-existent message based on message id
	 */
	public function testGetInvalidMessageByMessageId(){
		$message = Message::getMessageByMessageId($this->getPDO(), SproutSwapTest::INVALID_KEY);
		$this->assertNull($message);
	}
}