<?PHP
namespace Edu\Cnm\SproutSwap\SproutSwap;

use Edu\Cnm\SproutSwap\Test\SproutSwapTest;
use Edu\Cnm\SproutSwap\Post;
use Edu\Cnm\SproutSwap\PostImage;

require_once(dirname(__DIR__)) . "/autoload.php";

class PostImageTest extends SproutSwapTest{
	protected $VALID_POSTIMAGEIMAGEID = null;
	protected $VALID_POSTIMAGEPOSTID = "free";
	/**
	 * creating dependants
	 */
	public final function setUp(){
		parent::setUp();
		$this->post = new Post(null, null, null, "browser here or something", "post content here or something", "ip address", thisShouldBeAPoint, "vegetables", "different veggies tbh", null);
	}
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
	 *
	 */
	public function testInsertInvalidPostImage(){
		$postImage = new PostImage(SproutSwapTest::INVALID_KEY, SproutSwapTest::INVALID_KEY);
		$postImage->insert($this->getPDO());
	}
	/**
	 *
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

	public function testGetValidPostImageByPostImageImageId(){
		$numRows = $this->getConnection()->getRowCount("postImage");
		//create new postImage and update
		$postImage = new PostImage($this->VALID_POSTIMAGEIMAGEID, $this->VALID_POSTIMAGEPOSTID);
		$postImage->insert($this->getPDO());
		//grab data from mySQL and compare to expected
		$results = PostImage::getPostImageByPostImageImageId($this->getPDO());
		$pdoPostImage = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection->getRowCount("postImage"));
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\classes\\PostImage", $results);
		$this->assertEquals($pdoPostImage->getPostImageImageId(), $this->VALID_POSTIMAGEIMAGEID);
		$this->assertEquals($pdoPostImage->getPostImagePostId(), $this->VALID_POSTIMAGEPOSTID);
	}
}