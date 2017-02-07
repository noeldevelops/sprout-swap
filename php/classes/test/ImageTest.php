<?php
namespace Edu\Cnm\SproutSwap\Test;
use Edu\Cnm\SproutSwap\{Image, PostImage};

require_once("SproutSwapTest.php");
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHP Unit Test for the Image Class
 * @see  Image
 * @author Noel Cothren <noelcothren@gmail.com>
 **/
class ImageTest extends SproutSwapTest {
	protected $VALID_IMAGEID = null;
	protected $VALID_IMAGECLOUDINARYID = "dNO4tbbKFUG215Me";
	protected $INVALID_IMAGEID = 4294967296;
	protected $INVALID_IMAGECLOUDINARYID = "$$$$$$";

}
