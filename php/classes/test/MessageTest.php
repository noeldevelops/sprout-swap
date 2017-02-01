<?PHP
namespace Edu\Cnm\SproutSwap\Test;

//grab the project test
use Edu\Cnm\SproutSwap\DataDesign\Test\DataDesignTest;

require_once("DataDesignTest.php");

//grab the Message class
require_once(dirname(__DIR__)) . "/classes/autoload.php";

class messageTest extends DataDesignTest{
	protected $VALID_MESSAGEPOSTID = 7346376;
	protected $VALID_MESSAGERECEIVERPROFILEID = 4763643;
	protected $VALID_MESSAGESENDERPROFILEID = 345455;
	protected $VALID_MESSAGEBROWSER = "Message browser passing";
	protected $VALID_MESSAGECONTENT = "Message content passing";
	protected $VALID_MESSAGECONTENT2 = "Message updated content passing";
	protected $VALID_MESSAGEIPADDRESS = "IP passing";
	protected $VALID_MESSAGESTATUS = 2;
	protected $VALID_MESSAGETIMESTAMP = 128748376;

	public final function setUp(){
		parent::setUp();
		$this->message = new Message(null, "");
	}
}