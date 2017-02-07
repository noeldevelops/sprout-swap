<?php
namespace Edu\Cnm\SproutSwap\Test;
use Edu\Cnm\SproutSwap\{Image, PostImage};

require_once("SproutSwapTest.php");
require_once(dirname(__DIR__) . "/classes/autoload.php");

/**
 * Full PHP Unit Test for the Image Class
 * @see  Image
 * @author Noel Cothren <noelcothren@gmail.com>
 **/
class ImageTest extends SproutSwapTest {

	protected $VALID_IMAGEID;
	protected $VALID_IMAGECLOUDINARYID;
	protected $INVALID_IMAGEID;
	protected $INVALID_IMAGECLOUDINARYID;

}
