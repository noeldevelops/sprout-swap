<?PHP
namespace Edu\Cnm\SproutSwap\Test;

//grab the project test
use Edu\Cnm\SproutSwap\DataDesign\Test\DataDesignTest;
use Edu\Cnm\SproutSwap\Message;

require_once("DataDesignTest.php");

//grab the Message class
require_once(dirname(__DIR__)) . "/autoload.php";

class messageTest extends DataDesignTest{
	protected $VALID_MESSAGEPOSTID = 7346376;
	protected $VALID_MESSAGERECEIVERPROFILEID = 4763643;
	protected $VALID_MESSAGESENDERPROFILEID = 345455;
	protected $VALID_MESSAGEBROWSER = "Message browser passing";
	protected $VALID_MESSAGECONTENT = "Message content passing";
	protected $VALID_MESSAGECONTENT2 = "Message updated content passing";
	protected $VALID_MESSAGEIPADDRESS = "IP passing";
	protected $VALID_MESSAGESTATUS = 2;
	protected $VALID_MESSAGETIMESTAMP = null;
	/**
	 * creating dependent objects before running the test
	 */
	public final function setUp(){
		parent::setUp();
		$this->profile = new Profile(null, null, "ssssssssssssssss", "solomon.leyba@gmail.com", "ranch.me", null, "Solomon Leyba", );
	}
	public function testInsertValidMessage(){
		//store number of current rows to compare against
		$numRows = $this->getConnection()->getRowCount("message");
		//create new message and insert
		$this->message = new Message(null, );
	}
}