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
		$this->profile = new Profile(null, null, "kjsdhkj", "solomon.leyba@gmail.com", "ranch.me", null, "Solomon Leyba", "803AE81D0D6F67C1C0D307B39A99A93F6B6499B4C6E3F2ECE96718C5E2724B96", "5A929D9C14C5DF68BD2C97BBE2652754E26B3C9D23AC91978A0B9C0EAA3DE347", "god damn i love unit testing");
		$this->VALID_MESSAGETIMESTAMP = new \DateTime();

	}
	public function testInsertValidMessage(){
		//store number of current rows to compare against
		$numRows = $this->getConnection()->getRowCount("message");
		//create new message and insert
		$this->message = new Message(null, );
	}
}