<?php
namespace Edu\Cnm\SproutSwap\Test;
use Edu\Cnm\SproutSwap\{Image};

require_once("SproutSwapTest.php");
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHP Unit Test for the Image Class
 * @see  Image
 * @author Noel Cothren <noelcothren@gmail.com>
 **/
class ImageTest extends SproutSwapTest {
	protected $VALID_IMAGEID = null;
	protected $VALID_IMAGECLOUDINARYID = "l0MqIbg2yVjaYzAj";
	protected $INVALID_IMAGEID = 4294967296;
	protected $INVALID_IMAGECLOUDINARYID = 6;
	protected $VALID_POSTID = 78687;

	public function testInsertValidImage() {
		$numRows = $this->getConnection()->getRowCount("image");
		$image = new Image(null, $this->VALID_IMAGECLOUDINARYID);
		$image->insert($this->getPDO());
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getImageCloudinaryId(), $this->VALID_IMAGECLOUDINARYID);
	}

	/**
	 * test insert an image that already exists
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidImage() {
		$image = new Image($this->INVALID_IMAGEID, $this->VALID_IMAGECLOUDINARYID);
		$image->insert($this->getPDO());
	}
	/**
	 *test inserting an image and then deleting it
	 */
	public function testDeleteValidImage() {
		$numRows = $this->getConnection()->getRowCount("image");

		// create a new image and insert to into mySQL
		$image = new Image(null, $this->VALID_IMAGECLOUDINARYID);
		$image->insert($this->getPDO());

		// delete the image from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$image->delete($this->getPDO());

		// grab the data from mySQL and enforce the image does not exist
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertNull($pdoImage);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("image"));
	}

	/**
	 * test deleting an image that doesn't exist
	 * @expectedException \PDOException
	 */
	public function testDeleteInvalidImage() {
		// create a image and try to delete it without actually inserting it
		$image = new Image(null, $this->VALID_IMAGECLOUDINARYID);
		$image->delete($this->getPDO());
	}

	/*
 	* test getting an image by image id
 	*/
	public function testGetValidImageByImageId() {
		//count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("image");
		//create a new image and insert into mySqL
		$image = new Image(null, $this->VALID_IMAGECLOUDINARYID);
		$image->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getImageCloudinaryId(), $this->VALID_IMAGECLOUDINARYID);
	}
	/*
 * test getting an image by image id
 */
	public function testGetValidImageByImageCloudinaryId() {
		//count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("image");
		//create a new image and insert into mySqL
		$image = new Image(null, $this->VALID_IMAGECLOUDINARYID);
		$image->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoImage = Image::getImageByImageCloudinaryId($this->getPDO(), $image->getImageCloudinaryId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getImageCloudinaryId(), $this->VALID_IMAGECLOUDINARYID);
	}
}
