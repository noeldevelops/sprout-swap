<?PHP
namespace Edu\Cnm\SproutSwap\Test;

//grab the project test
use Edu\Cnm\SproutSwap\DataDesign\Test\DataDesignTest;
use Edu\Cnm\SproutSwap\Message;

require_once("DataDesignTest.php");

//grab the Message class
require_once(dirname(__DIR__)) . "/autoload.php";

class messageTest extends DataDesignTest{
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
		$message = new Message(null, $this->messageReceiverProfileId->profileId, $this->messageSenderProfileId->profileId, $this->VALID_MESSAGEBROWSER, $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEIPADDRESS, $this->VALID_MESSAGESTATUS, $this->VALID_MESSAGETIMESTAMP);

		$pdoMessage = Message::getMessageByMessageId($this->getPDO(), $message->getMessageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertEquals($pdoMessage->getMessageId(), $this->getMessageId());
		$this->assertEquals($pdoMessage->getMessageReceiverProfileId(), $this->profile->getMessageReceiverProfileId());
		$this->assertEquals($pdoMessage->getMessageSenderProfileId(), $this->profile->getMessageSenderProfileId());
		$this->assertEquals($pdoMessage->getMessageBrowser(), $this->VALID_MESSAGEBROWSER);
		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);
		$this->assertEquals($pdoMessage->getMessageIpAddress(), $this->VALID_MESSAGEIPADDRESS);
		$this->assertEquals($pdoMessage->getMessageStatus(), $this->VALID_MESSAGESTATUS);
		$this->assertEquals($pdoMessage->getMessageTimestamp(), $this->VALID_MESSAGEIPADDRESS);

	}
}