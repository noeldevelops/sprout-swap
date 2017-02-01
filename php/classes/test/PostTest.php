<?php
namespace Edu\Cnm\SproutSwap\Test;
use Edu\Cnm\SproutSwap\DataDesign\{Profile, Post};

require_once("DataDesignTest.php");

/**
 * Full PHP Unit Test for the Post Class
 * @see Post
 * @author Noel Cothren <noelcothren@gmail.com>
 **/
class PostTest extends DataDesignTest {
	/**
	 * content of the post
	 * @var string $VALID_POSTCONTENT
	 */
	protected $VALID_POSTCONTENT = "Post Content goes here";
	/**
	 * content of the updated post
	 * @var string $VALID_POSTCONTENT2
	 */
	protected $VALID_POSTCONTENT2 = "Revised and updated post content";
	/**
	 * timestamp of the post; starts as null and is assigned later
	 * @var \DateTime $VALID_POSTTIMESTAMP
	 */
	protected $VALID_POSTTIMESTAMP = null;
	/**
	 * Id of the profile that created the post
	 * @var int $VALID_POSTPROFILEID
	 */
	protected $VALID_POSTPROFILEID = null;
	/**
	 * some dependent objects to run tests with
	 **/
	public final function setUp() {
		parent::setUp();
		$this->post = new Post(null, 2, null, "browser", "content", "ipaddress", "location", "offer", "request", "2017-02-01");
		$this->post->insert($this->getPDO());
		$this->VALID_POSTTIMESTAMP = new \DateTime();
	}

}