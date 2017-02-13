<?PHP
namespace Edu\Cnm\SproutSwap\Test;

use Edu\Cnm\SproutSwap\{Post, PostImage, Point,Profile, Mode, Image};


require_once ("SproutSwapTest.php");
require_once(dirname(__DIR__)) . "/autoload.php";

/**
 * Class PostImageTest
 * @package Edu\Cnm\SproutSwap\Test
 * @author Solomon Leyba solomon.leyba@gmail.com
 */

class PostImageTest extends SproutSwapTest{
	protected $VALID_POSTIMAGEIMAGEID = null;
	protected $VALID_POSTIMAGEPOSTID = null;
	protected $VALID_LAT = 45.43;
	protected $VALID_LONG = 90.432;
	protected $VALID_TIMESTAMP = null;
	protected $VALID_IPADDRESS= "2600::dead:beef:cafe";
	protected $VALID_MODE = null;
	/**
	 * @var Point $newPoint
	 */
	private $newPoint = null;
	/**
	 * @var Post $post
	 */
	private $post = null;
	/**
	 * @var Profile $profile
	 */
	private $profile = null;
	/**
	 * @var Image $image
	 */
	private $image = null;
	/**
	 * creating dependants
	 */
	public final function setUp(){
		parent::setUp();
		$this->VALID_TIMESTAMP = new \DateTime();

		$this->image = new Image(null, "sjnghsklguenghtls");
		$this->image->insert($this->getPDO());

		$this->newPoint = new Point($this->VALID_LAT, $this->VALID_LONG);

		$this->VALID_MODE = new Mode(null, "Free");
		$this->VALID_MODE->insert($this->getPDO());

		$this->profile = new Profile(null, $this->image->getImageId(), "sdfsd", "djt@america.gov", "2600::dead:beef:cafe", $this->VALID_TIMESTAMP, "Noel Cothren", "9BB789D2052F1E787C89A700A59EF22DE1AFAEACC0E2DE97D22DC1D04284E871", "4C703B281FB196C94B61CC075B1F3191A0D9A4CEE2A46E153449728D3EC18503", "god damn i STILL love unit testing");
		$this->profile->insert($this->getPDO());

		$this->post = new Post(null, $this->VALID_MODE->getModeId(), $this->profile->getProfileId(), "browser here or something", "post content here or something", $this->VALID_IPADDRESS, $this->newPoint, "vegetables", "different veggies tbh", $this->VALID_TIMESTAMP);
		$this->post->insert($this->getPDO());
	}
	/**
	 * testing insert method
	 */
	public function testInsertValidPostImage(){
		//store number of current rows to compare against
		$numRows = $this->getConnection()->getRowCount("postImage");
		//create a new postImage and insert
		$postImage = new PostImage($this->image->getImageId(), $this->post->getPostId());
		$postImage->insert($this->getPDO());
		//enforce fields match expectations
		$pdoPostImage = PostImage::getPostImageByPostImageImageIdAndPostImagePostId($this->getPDO(), $postImage->getPostImageImageId(), $postImage->getPostImagePostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("postImage"));
		$this->assertEquals($pdoPostImage->getPostImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoPostImage->getPostImagePostId(), $this->post->getPostId());
	}
	/**
	 * testing insert method
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidPostImage(){
		$postImage = new PostImage(SproutSwapTest::INVALID_KEY, SproutSwapTest::INVALID_KEY);
		$postImage->insert($this->getPDO());
	}
	/**
	 * testing deletePostImage method
	 */
	public function testDeleteValidPostImage(){
		//count rows and save for later
		$numRows = $this->getConnection()->getRowCount("postImage");
		//create new postImage and insert
		$postImage = new PostImage($this->image->getImageId(), $this->post->getPostId());
		$postImage->insert($this->getPDO());
		//delete postImage from mySQL database
		$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("postImage"));
		$postImage->delete($this->getPDO());
		//grab and assert equality
		$pdoPostImage = PostImage::getPostImageByPostImageImageIdAndPostImagePostId($this->getPDO(), $postImage->getPostImageImageId(), $postImage->getPostImagePostId());
		$this->assertNull($pdoPostImage);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("postImage"));
	}
	/**
	 * @expectedException \PDOException
	 */
	public function testDeleteInvalidPostImage(){
		$postImage = new PostImage($this->image->getImageId(), $this->post->getPostId());
		$postImage->delete($this->getPDO());
	}
	/**
	 * testing GetValidPostImageByPostImageImageId
	 */
	public function testGetValidPostImageByPostImageImageId(){
		$numRows = $this->getConnection()->getRowCount("postImage");
		//create new postImage and update
		$postImage = new PostImage($this->image->getImageId(), $this->post->getPostId());
		$postImage->insert($this->getPDO());
		//grab data from mySQL and compare to expected
		$results = PostImage::getPostImageByPostImageImageId($this->getPDO(), $postImage->getPostImageImageId());
		$pdoPostImage = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("postImage"));
		$this->assertEquals($pdoPostImage->getPostImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoPostImage->getPostImagePostId(), $this->post->getPostId());
	}
	/**
	 * testing invalid case
	 */
	public function getInvalidPostImageByPostImageImageId(){
		$postImage = PostImage::getPostImageByPostImageImageId($this->getPDO(), $this->image->getImageId());
		$this->assertEquals(0, $postImage);
	}
	/**
	 *testing GetValidPostImageByPostImagePostId
	 */
	public function testGetValidPostImageByPostImagePostId(){
		$numRows = $this->getConnection()->getRowCount("postImage");
		//create new postImage and update
		$postImage = new PostImage($this->image->getImageId(), $this->post->getPostId());
		$postImage->insert($this->getPDO());
		$results = PostImage::getPostImageByPostImagePostId($this->getPDO(), $postImage->getPostImagePostId());
		$pdoPostImage = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("postImage"));
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\PostImage", $results);
		$this->assertEquals($pdoPostImage->getPostImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoPostImage->getPostImagePostId(), $this->post->getPostId());
	}
	/**
	 * testing for invalid case
	 */
	public function testGetInvalidPostImageByPostImagePostId(){
		$postImage = PostImage::getPostImageByPostImagePostId($this->getPDO(), $this->post->getPostId());
		$this->assertCount(0, $postImage);
	}
	/**
	 * testing getValidPostImageByPostImageImageIdAndPostImagePostId (for composite key)
	 */
	public function testGetValidPostImageByPostImageImageIdAndPostImagePostId(){
		//store num rows to test against
		$numRows = $this->getConnection()->getRowCount("postImage");
		//create new postImage and insert
		$postImage = new PostImage($this->image->getImageId(), $this->post->getPostId());
		$postImage->insert($this->getPDO());
		//grab data from mySQL and compare
		$pdoPostImage = PostImage::getPostImageByPostImageImageIdAndPostImagePostId($this->getPDO(), $postImage->getPostImageImageId(), $postImage->getPostImagePostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("postImage"));
		$this->assertEquals($pdoPostImage->getPostImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoPostImage->getPostImagePostId(), $this->post->getPostId());
	}
	/**
	 * testing GetPostImagesByPostImagePostId method
	 */
	public function testGetPostImagesByPostImagePostId(){
		//store num rows to test against
		$numRows = $this->getConnection()->getRowCount("postImage");
		//create new postImage and insert
		$postImage = new PostImage($this->image->getImageId(), $this->post->getPostId());
		$postImage->insert($this->getPDO());
		//grab mySQL data
		$results = PostImage::getPostImagesByPostImagePostId($this->getPDO(), $postImage->getPostImagePostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("postImage"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\PostImage", $results);
		//test one
		$pdoPostImage = $results[0];
		$this->assertEquals($pdoPostImage->getPostImageImageId(), $this->image->getImageId());
		$this->assertEquals($pdoPostImage->getPostImagePostId(), $this->post->getPostId());
	}
}