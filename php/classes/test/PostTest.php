<?php
namespace Edu\Cnm\SproutSwap\Test;
use Edu\Cnm\SproutSwap\{Profile, Post, Image, Point, Mode};

require_once("SproutSwapTest.php");
require_once(dirname(__DIR__) . "/autoload.php");

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
	protected $VALID_POSTSUNRISEDATE = null;
	protected $VALID_POSTSUNSETDATE = null;

	/**
	 * Id of the profile that created the post
	 * @var int $VALID_POSTPROFILEID
	 */
	protected $VALID_POSTPROFILEID = null;

	private $image = null;

	private $mode = null;

	private $profile = null;

	protected $VALID_POSTIPADDRESS = "2600::dead:beef:cafe";
	protected $VALID_POSTBROWSER = "Browser info passing";

	protected $VALID_POINT = null;
	protected $VALID_USERLOCATION = null;
	protected $VALID_USERDISTANCE = null;

	protected $INVALID_POSTLOCATION = null;

	/**
	 * some dependent objects to run tests with
	 **/
	public final function setUp() {
		parent::setUp();

		$this->image = new Image(null, "asdhfoaiteoing");
		$this->image->insert($this->getPDO());

		$this->mode = new Mode(null, "Free");
		$this->mode->insert($this->getPDO());

		$this->VALID_POSTTIMESTAMP = new \DateTime();

		$this->VALID_POSTSUNRISEDATE = new \DateTime();
		$this->VALID_POSTSUNRISEDATE->sub(new \DateInterval("P10D"));

		$this->VALID_POSTSUNSETDATE = new \DateTime();
		$this->VALID_POSTSUNSETDATE->add(new \DateInterval("P10D"));

		$this->VALID_USERLOCATION = new Point(35.10964229145246, -106.69703244562174);
		$this->VALID_POINT = new Point(35.084661, -106.655162);
		$this->VALID_USERDISTANCE = 5;

		/*a post location that is out of user's range*/
		$this->INVALID_POSTLOCATION = new Point(55.752047, 37.617821);

		//creating salt and hash
		$password = "123";
		$this->VALID_PROFILESALT = bin2hex(random_bytes(32));
		$this->VALID_PROFILEHASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILESALT, 262144);

		//create test Profile to make a test Post//
		$this->profile = new Profile(null, $this->image->getImageId(), "sdfsd", "trump.no@america.gov", "2600::dead:beef:cafe", $this->VALID_POSTTIMESTAMP, "Noel Cothren", $this->VALID_PROFILEHASH, $this->VALID_PROFILESALT, "god damn i STILL love unit testing");
		$this->profile->insert($this->getPDO());
	}

	/**
	 * test inserting a new Post and assert MySQL data matches
	 */
	public function testInsertValidPost() {
		//count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("post");
		//create a new Post and insert into mySqL
		$post = new Post(null, $this->mode->getModeId(), $this->profile->getProfileId(), $this->VALID_POSTBROWSER, $this->VALID_POSTCONTENT, $this->VALID_POSTIPADDRESS, $this->VALID_POINT, "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->insert($this->getPDO());
		//get the mySQL data and enforce the fields match our expectations
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertEquals($pdoPost->getPostId(), $post->getPostId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT);
		$this->assertEquals($pdoPost->getPostTimestamp(), $this->VALID_POSTTIMESTAMP);
	}

	/**
	 * test inserting a Post that already exists
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidPost() {
		//create a post with a non-null id and make sure it fails
		$post = new Post(SproutSwapTest::INVALID_KEY, $this->mode->getModeId(), $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, $this->VALID_POSTIPADDRESS, $this->VALID_POINT, "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->insert($this->getPDO());
	}

	/**
	 * test inserting a post, editing it, and updating it
	 */
	public function testUpdateValidPost() {
		//count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("post");
		//create a new Post and insert into mySqL
		$post = new Post(null, $this->mode->getModeId(), $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, $this->VALID_POSTIPADDRESS, $this->VALID_POINT, "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->insert($this->getPDO());
		//edit the post and update it
		$post->setPostContent($this->VALID_POSTCONTENT2);
		$post->update($this->getPDO());
		//get the mySQL data and enforce the fields match our expectations
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertEquals($pdoPost->getPostId(), $post->getPostId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT2);
		$this->assertEquals($pdoPost->getPostTimestamp(), $this->VALID_POSTTIMESTAMP);
	}

	/**
	 * test updating a post that doesn't exist
	 * @expectedException \PDOException
	 */
	public function testUpdateInvalidPost() {
		$post = new Post(null, $this->mode->getModeId(), $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, $this->VALID_POSTIPADDRESS, $this->VALID_POINT, "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->update($this->getPDO());
	}
	/*
	 * test creating a post and then deleting it
	 **/
	public function testDeleteValidPost() {
		//count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("post");
		//create a new Post and insert into mySqL
		$post = new Post(null,$this->mode->getModeId(), $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, $this->VALID_POSTIPADDRESS, $this->VALID_POINT, "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->insert($this->getPDO());
		//delete the post from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$post->delete($this->getPDO());
		//get the mySQL data and enforce the post does not exist
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertNull($pdoPost);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("post"));
	}
	/**
	 * test deleting a post that does not exist
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvalidPost() {
		//create a post and try to delete it without actually inserting it
		$post = new Post(null, $this->mode->getModeId(), $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, $this->VALID_POSTIPADDRESS, $this->VALID_POINT, "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->delete($this->getPDO());
	}
/**
 * test getting a valid post by post id
 */
public function testGetValidPostByPostId() {
	//count number of rows and save for later
	$numRows = $this->getConnection()->getRowCount("post");
	//create a new Post and insert into mySqL
	$post = new Post(null, $this->mode->getModeId(), $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, $this->VALID_POSTIPADDRESS, $this->VALID_POINT, "offer", "request", $this->VALID_POSTTIMESTAMP);
	$post->insert($this->getPDO());
	// grab the data from mySQL and enforce the fields match our expectations
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
	}
	/**
	 * test getting a post by invalid post id
	 * @expectedException \PDOException
	 */
	public function testGetPostByInvalidPostId() {
		//count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("post");
		//create a new Post and insert into mySqL
		$post = new Post(32, $this->mode->getModeId(), $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, $this->VALID_POSTIPADDRESS, $this->VALID_POINT, "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
	}
	/**
	 * test get all posts by Mode Id
	 */
	public function testGetPostsByPostModeId () {
		$numRows = $this->getConnection()->getRowCount("post");
		$post = new Post(null, $this->mode->getModeId(), $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, $this->VALID_POSTIPADDRESS, $this->VALID_POINT, "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->insert($this->getPDO());

		$results = Post::getPostsByPostModeId($this->getPDO(), $post->getPostModeId());

		$this->assertCount(1, $results);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Post", $results);
	}
	/**
	 * test get all posts by Profile Id
	 */
	public function testGetPostsByPostProfileId () {
		$numRows = $this->getConnection()->getRowCount("post");
		$post = new Post(null, $this->mode->getModeId(), $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, $this->VALID_POSTIPADDRESS, $this->VALID_POINT, "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->insert($this->getPDO());

		$results = Post::getPostsByPostProfileId($this->getPDO(), $post->getPostProfileId());

		$this->assertCount(1, $results);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Post", $results);
	}
	/**
	 * test get posts by post content
	 */
	public function testGetPostsByPostContent () {
		$numRows = $this->getConnection()->getRowCount("post");
		$post = new Post(null, $this->mode->getModeId(), $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, $this->VALID_POSTIPADDRESS, $this->VALID_POINT, "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->insert($this->getPDO());


		$results = Post::getPostsByPostContent($this->getPDO(), $post->getPostContent());

		$this->assertCount(1, $results);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Post", $results);
	}
	/**
	 * test get posts by location
	 */
	public function testGetPostsByPostLocation () {
		$numRows = $this->getConnection()->getRowCount("post");

		$post = new Post(null, $this->mode->getModeId(), $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, $this->VALID_POSTIPADDRESS, $this->VALID_POINT, "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->insert($this->getPDO());

		$results = Post::getPostsByPostLocation($this->getPDO(), $post->getPostLocation(), 5);
var_dump($results);
		foreach($results as $post) {
			$this->assertEquals($post->getPostLocation()->getLat(), $this->VALID_POINT->getLat(), '', 0.6);
			$this->assertEquals($post->getPostLocation()->getLong(), $this->VALID_POINT->getLong(), '', 0.6);
		}

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Post", $results);
	}
	/**
	 * test getting posts that are too far
	 */
	public function testGetInvalidPostsByPostLocation () {
		$numRows = $this->getConnection()->getRowCount("post");

		$post = new Post(null, $this->mode->getModeId(), $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, $this->VALID_POSTIPADDRESS, $this->INVALID_POSTLOCATION, "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->insert($this->getPDO());

		$results = Post::getPostsByPostLocation($this->getPDO(), $this->VALID_USERLOCATION, $this->VALID_USERDISTANCE);

		foreach($results as $post) {
			$this->assertSame($post->getPostLocation->getLat(), $this->VALID_USERLOCATION->getLat(), '', 0.6);
			$this->assertSame($post->getPostLocation->getLong(), $this->VALID_USERLOCATION->getLong(), '', 0.6);
		}
		$this->assertEmpty($results);
	}
	/**
	 * test get posts by post offer
	 */
	public function testGetPostsByPostOffer () {
		$numRows = $this->getConnection()->getRowCount("post");
		$post = new Post(null, $this->mode->getModeId(), $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, $this->VALID_POSTIPADDRESS, $this->VALID_POINT, "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->insert($this->getPDO());

		$results = Post::getPostsByPostOffer($this->getPDO(), $post->getPostOffer());

		$this->assertCount(1, $results);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Post", $results);
	}
	/**
	 * test get posts by request
	 */
	public function testGetPostsByPostRequest () {
		$numRows = $this->getConnection()->getRowCount("post");
		$post = new Post(null, $this->mode->getModeId(), $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, $this->VALID_POSTIPADDRESS, $this->VALID_POINT, "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->insert($this->getPDO());

		$results = Post::getPostsByPostRequest($this->getPDO(), $post->getPostRequest());

		$this->assertCount(1, $results);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Post", $results);
	}
	/**
	 * test get posts by timestamp
	 */
	public function testGetPostsByPostTimestamp () {
		$numRows = $this->getConnection()->getRowCount("post");

		$post = new Post(null, $this->mode->getModeId(), $this->profile->getProfileId(), "browser", $this->VALID_POSTCONTENT, $this->VALID_POSTIPADDRESS, $this->VALID_POINT, "offer", "request", $this->VALID_POSTTIMESTAMP);
		$post->insert($this->getPDO());

		$results = Post::getPostsByPostTimestamp($this->getPDO(), $this->VALID_POSTSUNRISEDATE, $this->VALID_POSTSUNSETDATE);


		$this->assertCount(1, $results);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Post", $results);

		$pdoPost = $results[0];
		$this->assertEquals($pdoPost->getPostId(), $post->getPostId());
	}
}