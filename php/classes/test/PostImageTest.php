<?PHP
namespace Edu\Cnm\SproutSwap\Test;

use Edu\Cnm\SproutSwap\{Post, PostImage, Point};

require_once ("SproutSwapTest.php");
require_once(dirname(__DIR__)) . "/autoload.php";

/**
 * Class PostImageTest
 * @package Edu\Cnm\SproutSwap\Test
 * @author Solomon Leyba solomon.leyba@gmail.com
 */

class PostImageTest extends SproutSwapTest{
	protected $VALID_POSTIMAGEIMAGEID = null;
	protected $VALID_POSTIMAGEPOSTID = "free";
	protected $VALID_LAT = 45.43;
	protected $VALID_LONG = 90.432;
	protected $newPoint = null;
	protected $post = null;
	/**
	 * creating dependants
	 */
	public final function setUp(){
		parent::setUp();
		$newPoint = new Point($this->VALID_LAT, $this->VALID_LONG);
		$this->post = new Post(null, $this->getPostModeId(), "browser here or something", "post content here or something", "2600::dead:beef:cafe", $newPoint, "vegetables", "different veggies tbh", null);
	}
	/**
	 * testing insert method
	 */
	public function testInsertValidPostImage(){
		//store number of current rows to compare against
		$numRows = $this->getConnection()->getRowCount("message");
		//create a new postImage and insert
		$postImage = new PostImage($this->VALID_POSTIMAGEIMAGEID, $this->VALID_POSTIMAGEPOSTID);
		$postImage->insert($this->getPDO());
		//enforce fields match expectations
		$pdoPostImageImageId = self::getPostImageImageId($this->getPDO());
		$pdoPostImagePostId = self::getPostImagePostId($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertEquals($pdoPostImageImageId, $this->VALID_POSTIMAGEIMAGEID);
		$this->assertEquals($pdoPostImagePostId, $this->VALID_POSTIMAGEPOSTID);
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
		$postImage = new PostImage($this->VALID_POSTIMAGEIMAGEID, $this->VALID_POSTIMAGEPOSTID);
		$postImage->insert($this->getPDO());
		//delete postImage from mySQL database
		$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("postimage"));
		$postImage->delete($this->getPDO());
		//grab and assert equality
		$pdoPostImage = PostImage::getPostImageByPostImageId($this->getPDO(), $postImage->getPostImageImageId());
		$this->assertNull($pdoPostImage);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("postImage"));
	}
	/**
	 * @expectedException \PDOException
	 */
	public function testDeleteInvalidPostImage(){
		$postImage = new PostImage($this->VALID_POSTIMAGEIMAGEID, $this->VALID_POSTIMAGEPOSTID);
		$postImage->delete($this->getPDO());
	}
	/**
	 * testing GetValidPostImageByPostImageImageId
	 */
	public function testGetValidPostImageByPostImageImageId(){
		$numRows = $this->getConnection()->getRowCount("postImage");
		//create new postImage and update
		$postImage = new PostImage($this->VALID_POSTIMAGEIMAGEID, $this->VALID_POSTIMAGEPOSTID);
		$postImage->insert($this->getPDO());
		//grab data from mySQL and compare to expected
		$results = PostImage::getPostImageByPostImageImageId($this->getPDO());
		$pdoPostImage = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("postImage"));
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\classes\\PostImage", $results);
		$this->assertEquals($pdoPostImage->getPostImageImageId(), $this->VALID_POSTIMAGEIMAGEID);
		$this->assertEquals($pdoPostImage->getPostImagePostId(), $this->VALID_POSTIMAGEPOSTID);
	}
	/**
	 * twsting invalid case
	 */
	public function getInvalidPostImageByPostImageImageId(){
		$postImage = PostImage::getPostImageByPostImageImageId($this->getPDO(), "hope there's nothitng -_-");
		$this->assertEquals(0, $postImage);
	}
	/**
	 *testing GetValidPostImageByPostImagePostId
	 */
	public function testGetValidPostImageByPostImagePostId(){
		$numRows = $this->getConnection()->getRowCount("postImage");
		//create new postImage and update
		$postImage = new PostImage($this->VALID_POSTIMAGEIMAGEID, $this->VALID_POSTIMAGEPOSTID);
		$postImage->insert($this->getPDO());
		$results = PostImage::getPostImageByPostImagePostId($this->getPDO());
		$pdoPostImage = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("postImage"));
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\classes\\PostImage", $results);
		$this->assertEquals($pdoPostImage->getPostImageImageId(), $this->VALID_POSTIMAGEIMAGEID);
		$this->assertEquals($pdoPostImage->getPostImagePostId(), $this->VALID_POSTIMAGEPOSTID);
	}
	/**
	 * testing for invalid case
	 */
	public function testGetInvalidPostImageByPostImagePostId(){
		$postImage = PostImage::getPostImageByPostImagePostId($this->getPDO(), "hope there's nothing -_-");
		$this->assertEquals(0, $postImage);
	}
	/**
	 * testing etValidPostImageByPostImageImageIdAndPostImagePostId (for composite key)
	 */
	public function testGetValidPostImageByPostImageImageIdAndPostImagePostId(){
		//store num rows to test against
		$numRows = $this->getConnection()->getRowCount("postImage");
		//create new postImage and insert
		$postImage = new PostImage($this->VALID_POSTIMAGEIMAGEID, $this->VALID_POSTIMAGEPOSTID);
		$postImage->insert($this->getPDO());
		//grab data from mySQL and compare
		$pdoPostImage = PostImage::getPostImageByPostImageImageIdAndPostImagePostId($this->getPDO(), $postImage->getPostImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("postImage"));
		$this->assertEquals($pdoPostImage->getPostImageImageId(), $this->VALID_POSTIMAGEIMAGEID);
		$this->assertEquals($pdoPostImage->getPostImagePostId(), $this->VALID_POSTIMAGEPOSTID);
	}
	/**
	 * testing GetPostImagesByPostImagePostId method
	 */
	public function testGetPostImagesByPostImagePostId(){
		//store num rows to test against
		$numRows = $this->getConnection()->getRowCount("postImage");
		//create new postImage and insert
		$postImage = new PostImage($this->VALID_POSTIMAGEIMAGEID, $this->VALID_POSTIMAGEPOSTID);
		$postImage->insert($this->getPDO());
		//grab mySQL data
		$results = PostImage::getPostImagesByPostImagePostId($this->getPDO(), $this->VALID_POSTIMAGEPOSTID);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("postImage"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\PostImage");
		//test one
		$pdoPostImage = $results[0];
		$this->assertEquals($pdoPostImage->getPostImageImageId(), $this->VALID_POSTIMAGEIMAGEID);
		$this->assertEquals($pdoPostImage->getPostImagePostId(), $this->VALID_POSTIMAGEPOSTID);
	}
}