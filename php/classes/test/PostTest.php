<?php
namespace Edu\Cnm\SproutSwap\Test;
use Edu\Cnm\SproutSwap\SproutSwap\{Profile, Post};

require_once("SproutSwapTest.php");
require_once(dirname(__DIR__) . "/classes/autoload.php");

/**
 * Full PHP Unit Test for the Post Class
 * @see Post
 * @author Noel Cothren <noelcothren@gmail.com>
 **/
class PostTest extends SproutSwapTest {
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
		//create test Profile to make a test Post
		$this->profile = new Profile(null, null, "activation", "this@email.com", "handle", "timestamp", "My Name", "803AE81D0D6F67C1C0D307B39A99A93F6B6499B4C6E3F2ECE96718C5E2724B96", "5A929D9C14C5DF68BD2C97BBE2652754E26B3C9D23AC91978A0B9C0EAA3DE347", "This is my really cool profile.");
		$this->profile->insert($this->getPDO());
		$this->VALID_POSTTIMESTAMP = new \DateTime();
	}

	/**
	 * test inserting a new Post and assert MySQL data matches
	 */
	public function testInsertValidPost() {
		//count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("post");
		//create a new Post and insert into mySqL
		$post = new Post(null, 2, $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, "IP Address", "location", "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->insert($this->getPDO());
		//get the mySQL data and enforce the fields match our expectations
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertEquals($pdoPost->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT);
		$this->assertEquals($pdoPost->getPostTimestamp(), $this->VALID_POSTTIMESTAMP);
	}

	/*
	 * test inserting a Post that already exists
	 * @expectedException PDOException
	 */
	public function testInsertInvalidPost() {
		//create a post with a non-null id and make sure it fails
		$post = new Post(SproutSwapTest::INVALID_KEY, 2, $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, "IP Address", "location", "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->insert($this->getPDO());
	}

	/**
	 * test inserting a post, editing it, and updating it
	 */
	public function testUpdateValidPost() {
		//count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("post");
		//create a new Post and insert into mySqL
		$post = new Post(null, 2, $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, "IP Address", "location", "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->insert($this->getPDO());
		//edit the post and update it
		$post->setPostContent($this->VALID_POSTCONTENT2);
		$post->update($this->getPDO());
		//get the mySQL data and enforce the fields match our expectations
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertEquals($pdoPost->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT2);
		$this->assertEquals($pdoPost->getPostTimestamp(), $this->VALID_POSTTIMESTAMP);
	}

	/**
	 * test updating a post that doesn't exist
	 */
	public function testUpdateInvalidPost() {
		$post = new Post(null, 2, $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, "IP Address", "location", "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->update($this->getPDO());
	}
	/*
	 * test creating a post and then deleting it
	 **/
	public function testDeleteValidPost() {
		//count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("post");
		//create a new Post and insert into mySqL
		$post = new Post(null, 2, $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, "IP Address", "location", "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->insert($this->getPDO());
		//delete the post from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$post->delete($this->getPDO());
		//get the mySQL data and enforce the post does not exist
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId);
		$this->assertNull($pdoPost);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("post"));
	}
	/**
	 * test deleting a post that doesn't exist
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvalidPost() {
		//create a post and try to delete it without actually inserting it
		$post = new Post(null, 2, $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, "IP Address", "location", "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->delete($this->getPDO());
	}
/*
 * test getting a post by post id
 */
public function testGetValidPostByPostId() {
	//count number of rows and save for later
	$numRows = $this->getConnection()->getRowCount("post");
	//create a new Post and insert into mySqL
	$post = new Post(null, 2, $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, "IP Address", "location", "offer", "request", $this->VALID_POSTTIMESTAMP);
	$post->insert($this->getPDO());
	// grab the data from mySQL and enforce the fields match our expectations
		$results = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap", $results);
}
}