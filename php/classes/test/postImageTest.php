<?PHP
namespace Edu\Cnm\SproutSwap\DataDesign;

use Edu\Cnm\SproutSwap\DataDesign\DataDesignTest;
use Edu\Cnm\SproutSwap\Post;
use Edu\Cnm\SproutSwap\PostImage;

require_once(dirname(__DIR__)) . "/autoload.php";

class PostImageTest extends DataDesignTest{
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
		$pdoPostImage = PostImage::getPostImageByPostImageId();

	}
}