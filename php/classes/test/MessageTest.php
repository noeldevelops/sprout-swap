<?PHP
namespace Edu\Cnm\SproutSwap\Test;

//grab the project test
use Edu\Cnm\SproutSwap\{Profile, Message, Image};

require_once("SproutSwapTest.php");

//grab the Message class
require_once(dirname(__DIR__) . "/autoload.php");

class MessageTest extends SproutSwapTest{
	protected $VALID_MESSAGEPOSTID = null;
	protected $VALID_MESSAGERECEIVERPROFILEID = null;
	protected $VALID_MESSAGESENDERPROFILEID = null;
	protected $VALID_MESSAGEBROWSER = "Message browser passing";
	protected $VALID_MESSAGECONTENT = "Message content passing";
	protected $VALID_MESSAGECONTENT2 = "Message updated content passing";
	protected $VALID_MESSAGEIPADDRESS = "IP passing";
	protected $VALID_MESSAGESTATUS = 2;
	protected $VALID_MESSAGETIMESTAMP = null;
	/**
	 * set up for test
	 * creating dependent objects before running the test
	 */
	public final function setUp(){
		parent::setUp();
		$this->image = new Image(null, "sjnghsklguenghtls");
		$this->receiverProfile = new Profile(null, null, "kjsdhkj", "solomon.leyba@gmail.com", "ranch.me", null, "Solomon Leyba", "803AE81D0D6F67C1C0D307B39A99A93F6B6499B4C6E3F2ECE96718C5E2724B96", "5A929D9C14C5DF68BD2C97BBE2652754E26B3C9D23AC91978A0B9C0EAA3DE347", "god damn i love unit testing");
		$this->senderProfile = new Profile(null, null, "sdfsd", "djt@america.gov", "hello_us", null, "Noel Cothren", "9BB789D2052F1E787C89A700A59EF22DE1AFAEACC0E2DE97D22DC1D04284E871", "4C703B281FB196C94B61CC075B1F3191A0D9A4CEE2A46E153449728D3EC18503", "god damn i STILL love unit testing");
		$this->VALID_MESSAGETIMESTAMP = new \DateTime();

	}
	public function testInsertValidMessage(){
		//store number of current rows to compare against
		$numRows = $this->getConnection()->getRowCount("message");
		//create new message and insert
		$message = new Message(null, $this->messageReceiverProfileId->getProfileId(), $this->messageSenderProfileId->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
		$message->insert($this->getPDO());
		// enforce fields match expectation
		$pdoMessage = Message::getMessageByMessageId($this->getPDO(), $message->getMessageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertEquals($pdoMessage->getMessageId(), $this->getMessageId());
		$this->assertEquals($pdoMessage->getMessageReceiverProfileId(), $this->receiverProfile->getMessageReceiverProfileId());
		$this->assertEquals($pdoMessage->getMessageSenderProfileId(), $this->senderProfile->getMessageSenderProfileId());
		$this->assertEquals($pdoMessage->getMessageBrowser(), $this->VALID_MESSAGEBROWSER);
		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageIpAddress(), $this->VALID_MESSAGEIPADDRESS);
		$this->assertEquals($pdoMessage->getMessageStatus(), $this->VALID_MESSAGESTATUS);
		$this->assertEquals($pdoMessage->getMessageTimestamp(), $this->VALID_MESSAGEIPADDRESS);
	}
	/**
	 * test insert invalid message
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidMessage(){
		//create a message w non-null message id
		$message = new Message(SproutSwapTest::INVALID_KEY, $this->messageReceiverProfileId->getProfileId(), $this->messageSenderProfileId->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
		$message->insert($this->getPDO());
	}

	/**
	 * test update valid message
	 */
	public function testUpdateValidMessage(){
		//store number of current rows to compare against
		$numRows = $this->getConnection()->getRowCount("message");
		//create new message and insert
		$message = new Message(null, $this->messageReceiverProfileId->getProfileId(), $this->messageSenderProfileId->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
		$message->insert($this->getPDO());
		//edit the message and update in mySQL
		$message->setMessageContent($this->VALID_MESSAGECONTENT2);
		$message->update($this->getPDO());
		//grab data and ensure it matches expectations
		$pdoMessage = Message::getMessageByMessageId($this->getPDO(), $message->getMessageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertEquals($pdoMessage->getMessageId(), $this->getMessageId());
		$this->assertEquals($pdoMessage->getMessageReceiverProfileId(), $this->receiverProfile->getMessageReceiverProfileId());
		$this->assertEquals($pdoMessage->getMessageSenderProfileId(), $this->senderProfile->getMessageSenderProfileId());
		$this->assertEquals($pdoMessage->getMessageBrowser(), $this->VALID_MESSAGEBROWSER);
		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT2);
		$this->assertEquals($pdoMessage->getMessageIpAddress(), $this->VALID_MESSAGEIPADDRESS);
		$this->assertEquals($pdoMessage->getMessageStatus(), $this->VALID_MESSAGESTATUS);
		$this->assertEquals($pdoMessage->getMessageTimestamp(), $this->VALID_MESSAGEIPADDRESS);
	}
	/**
	 * test updating invalid message
	 * @expectedException \PDOException
	 */
	public function testUpdateInvalidMessage(){
		$message = new Message(SproutSwapTest::INVALID_KEY, $this->messageReceiverProfileId->getProfileId(), $this->messageSenderProfileId->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
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
		$message = new Message(null, $this->messageReceiverProfileId->getProfileId(), $this->messageSenderProfileId->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
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
		$message = new Message(null, $this->messageReceiverProfileId->getProfileId(), $this->messageSenderProfileId->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
		$message->delete($this->getPDO());
	}
	/**
	 * testing getting a valid message from sender profile Id
	 */
	public function testGetValidMessageByMessageSenderProfileId() {
		//store number of current rows to compare against
		$numRows = $this->getConnection()->getRowCount("message");
		//create new message and insert
		$message = new Message(null, $this->messageReceiverProfileId->getProfileId(), $this->messageSenderProfileId->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
		$message->insert($this->getPDO());
		//grab data from mySQL to check against expected
		$results = Message::getMessageByMessageSenderProfileId($this->getPDO(), $message->getMessageContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\classes\\Message", $results);
		//grab result from array and validate
		$pdoMessage = $results[0];
		$this->assertEquals($pdoMessage->getMessageId(), $this->getMessageId());
		$this->assertEquals($pdoMessage->getMessageReceiverProfileId(), $this->receiverProfile->getMessageReceiverProfileId());
		$this->assertEquals($pdoMessage->getMessageSenderProfileId(), $this->senderProfile->getMessageSenderProfileId());
		$this->assertEquals($pdoMessage->getMessageBrowser(), $this->VALID_MESSAGEBROWSER);
		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageIpAddress(), $this->VALID_MESSAGEIPADDRESS);
		$this->assertEquals($pdoMessage->getMessageStatus(), $this->VALID_MESSAGESTATUS);
		$this->assertEquals($pdoMessage->getMessageTimestamp(), $this->VALID_MESSAGEIPADDRESS);
	}
	/**
	 * testing searching for an invalid message based on sender profile id
	 */
	public function testGetInvalidMessageByMessageSenderProfileId(){
		$message = Message::getMessageByMessageSenderProfileId($this->getPDO(), "hope i find nothing!!");
		$this->assertCount(0, $message);
	}

	/**
	 * testing searching for a valid message based on receiver profile id
	 */
	public function testGetValidMessageByMessageReceiverProfileId() {
		//store number of current rows to compare against
		$numRows = $this->getConnection()->getRowCount("message");
		//create new message and insert
		$message = new Message(null, $this->messageReceiverProfileId->getProfileId(), $this->messageSenderProfileId->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
		$message->insert($this->getPDO());
		//grab data from mySQL to check against expected
		$results = Message::getMessageByMessageReceiverProfileId($this->getPDO(), $message->getMessageContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\classes\\Message", $results);
		//grab result from array and validate
		$pdoMessage = $results[0];
		$this->assertEquals($pdoMessage->getMessageId(), $this->getMessageId());
		$this->assertEquals($pdoMessage->getMessageReceiverProfileId(), $this->receiverProfile->getMessageReceiverProfileId());
		$this->assertEquals($pdoMessage->getMessageSenderProfileId(), $this->senderProfile->getMessageSenderProfileId());
		$this->assertEquals($pdoMessage->getMessageBrowser(), $this->VALID_MESSAGEBROWSER);
		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageIpAddress(), $this->VALID_MESSAGEIPADDRESS);
		$this->assertEquals($pdoMessage->getMessageStatus(), $this->VALID_MESSAGESTATUS);
		$this->assertEquals($pdoMessage->getMessageTimestamp(), $this->VALID_MESSAGEIPADDRESS);
	}

	/**
	 * testing searching for an invalid message based on receiver profile id
	 */
	public function testGetInvalidMessageByMessageReceiverProfileId(){
		$message = Message::getMessageByMessageSenderProfileId($this->getPDO(), "hope i find nothing!!");
		$this->assertCount(0, $message);
	}
	/**
	 * test grabbing valid messages based on post id
	 */
	public function testGetValidMessageByMessagePostId(){
		//store number of current rows to compare against
		$numRows = $this->getConnection()->getRowCount("message");
		//create new message and insert
		$message = new Message(null, $this->messageReceiverProfileId->getProfileId(), $this->messageSenderProfileId->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
		$message->insert($this->getPDO());
		//grab data from mySQL to check against expected
		$results = Message::getMessageByMessagePostId($this->getPDO(), $message->getMessageContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\php\\classes\\Message", $results);
		//grab result from array and validate
		$pdoMessage = $results[0];
		$this->assertEquals($pdoMessage->getMessageId(), $this->getMessageId());
		$this->assertEquals($pdoMessage->getMessageReceiverProfileId(), $this->receiverProfile->getMessageReceiverProfileId());
		$this->assertEquals($pdoMessage->getMessageSenderProfileId(), $this->senderProfile->getMessageSenderProfileId());
		$this->assertEquals($pdoMessage->getMessageBrowser(), $this->VALID_MESSAGEBROWSER);
		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageIpAddress(), $this->VALID_MESSAGEIPADDRESS);
		$this->assertEquals($pdoMessage->getMessageStatus(), $this->VALID_MESSAGESTATUS);
		$this->assertEquals($pdoMessage->getMessageTimestamp(), $this->VALID_MESSAGEIPADDRESS);
	}
	/**
	 * test grabbing invalid message based on message post id
	 */
	public function testGetInvalidMessageByMessagePostId(){
		$message = Message::getMessageByMessagePostId($this->getPDO(), "find nothin plz");
		$this->assertCount(0, $message);
	}
	/**
	 * testing grabbing a valid message based on message content
	 */
	public function testGetValidMessageByMessageContent(){
		//store number of current rows to compare against
		$numRows = $this->getConnection()->getRowCount("message");
		//create new message and insert
		$message = new Message(null, $this->messageReceiverProfileId->getProfileId(), $this->messageSenderProfileId->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
		$message->insert($this->getPDO());
		// grab mySQL data and enforce it matches expectations
		$results = Message::getMessageByMessageContent($this->getPDO(), $message->getMessageContent());
		$this->assertCount(1, $results);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\php\\classes\\Message", $results);
		//grab array result and verify
		$pdoMessage = $results[0];
		$this->assertEquals($pdoMessage->getMessageId(), $this->getMessageId());
		$this->assertEquals($pdoMessage->getMessageReceiverProfileId(), $this->receiverProfile->getMessageReceiverProfileId());
		$this->assertEquals($pdoMessage->getMessageSenderProfileId(), $this->senderProfile->getMessageSenderProfileId());
		$this->assertEquals($pdoMessage->getMessageBrowser(), $this->VALID_MESSAGEBROWSER);
		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageIpAddress(), $this->VALID_MESSAGEIPADDRESS);
		$this->assertEquals($pdoMessage->getMessageStatus(), $this->VALID_MESSAGESTATUS);
		$this->assertEquals($pdoMessage->getMessageTimestamp(), $this->VALID_MESSAGEIPADDRESS);
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
		$message = new Message(null, $this->messageReceiverProfileId->getProfileId(), $this->messageSenderProfileId->getProfileId(), $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);
		$message->insert($this->getPDO());
		//grab and validate
		$pdoMessage = Message::getMessageByMessageId();
		$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("message"));
		$this->assertEquals($pdoMessage->getMessageId(), $this->getMessageId());
		$this->assertEquals($pdoMessage->getMessageReceiverProfileId(), $this->receiverProfile->getMessageReceiverProfileId());
		$this->assertEquals($pdoMessage->getMessageSenderProfileId(), $this->senderProfile->getMessageSenderProfileId());
		$this->assertEquals($pdoMessage->getMessageBrowser(), $this->VALID_MESSAGEBROWSER);
		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageIpAddress(), $this->VALID_MESSAGEIPADDRESS);
		$this->assertEquals($pdoMessage->getMessageStatus(), $this->VALID_MESSAGESTATUS);
		$this->assertEquals($pdoMessage->getMessageTimestamp(), $this->VALID_MESSAGEIPADDRESS);
	}
	/**
	 * testing grabbing a non-existent message based on message id
	 */
	public function testGetInvalidMessageByMessageId(){
		$message = Message::getMessageByMessageId($this->getPDO(), "nothing");
		$this->assertCount(0, $message);
	}
}