<?php
namespace Edu\Cnm\SproutSwap\Test;

//grab project test
use Edu\Cnm\SproutSwap\{Mode};
require_once("SproutSwapTest.php");

//grab the mode class
require_once(dirname(__DIR__) . "/autoload.php");

//author Zak Abad <abad.zacaria@gmail.com>

class ModeTest extends SproutSwapTest {
	/**
	 * name for modeId
	 * @var int modeId
	 **/
	protected $VALID_MODENAME = "Free";
	/**
	 * modeName for updated Mode
	 * @var string $VALID_MODENAME2
	 **/
	protected $VALID_MODENAME2 = "Sell";
	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp(){
		//run the default seUp() method first
		parent::setUp();

	}
	/**
	 * test inserting a valid Mode and verify that the actual mySQL data matches
	 **/

	public function testInsertValidMode(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("mode");

		//create a new Mode and insert to into mySQL
		$mode = new Mode(null, $this->VALID_MODENAME);
		$mode->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoMode = Mode::getModeByModeId($this->getPDO(), $mode->getModeId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("mode"));
		$this->assertEquals($pdoMode->getModeName(), $this->VALID_MODENAME);
	}

	/**
	 * test inserting a Mode that already exists
	 *
	 * @expectedException \PDOException
	 **/

	public function testInsertInvalidMode(){
		//create a Mode with a non null mode id and watch it fail
		$mode = new Mode(SproutSwapTest::INVALID_KEY, $this->VALID_MODENAME);
		$mode->insert($this->getPDO());
	}

	/**
	 * test test inserting a Profile, editing it, and then updating it
	 **/

	public function testUpdateValidMode(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("mode");

		//create a new Mode and insert to into mySQL
		$mode = new Mode(null, $this->VALID_MODENAME);
		$mode->insert($this->getPDO());

		//edit the Mode and update it in mySQL
		$mode->setModeName($this->VALID_MODENAME2);
		$mode->update($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoMode = Mode::getModeByModeId($this->getPDO(), $mode->getModeId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("mode"));
		$this->assertEquals($pdoMode->getModeName(), $this->VALID_MODENAME2);
	}

	/**
	 * test updating a Mode that does not exist
	 *
	 * @expectedException PDOException
	 **/

	public function testUpdateInvalidMode(){
		//create a Mode, try to update it without actually updating it and watch it fail
		$mode = new Mode(null, $this->VALID_MODENAME);
		$mode->update($this->getPDO());
	}

	/**
	 * test creating a Mode and then deleting it
	 **/

	public function testDeleteValidMode(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("mode");

		//create a new Mode and insert to into mySQL
		$mode = new Mode(null, $this->VALID_MODENAME);
		$mode->insert($this->getPDO());

		//delete the mode from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("mode"));
		$mode->delete($this->getPDO());

		//grab the data from mySQL and enforce the Mode does not exist
		$pdoMode = Mode::getModeByModeId($this->getPDO(), $mode->getModeId());
		$this->assertNull($pdoMode);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("mode"));
	}

	/**
	 * test deleting a Mode that does not exist
	 *
	 * @expectedException PDOException
	 **/

	public function testDeleteInvalidMode(){
		//create a Mode and try to delete it without actually inserting it
		$mode = new Mode(null, $this->VALID_MODENAME);
		$mode->delete($this->getPDO());
	}

	/**
	 * test grabbing a Mode by mode name
	 **/

	public function testGetValidModeByModeName(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("mode");

		//create a new Mode and insert to into mySQL
		$mode = new Mode(null, $this->VALID_MODENAME);
		$mode->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Mode::getModeByModeName($this->getPDO(), $mode->getModeName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("mode"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Mode", $results);

		//grab the result from the array and validate it
		$pdoMode = $results[0];
		$this->assertEquals($pdoMode->getModeName(), $this->VALID_MODENAME);
	}

	/**
	 * test grabbing a Mode by name that does not exist
	 **/

	public function testGetInvalidModeByName(){
	//grab mode by searching for name that does not exist
	$mode = Mode::getModeByModeName($this->getPDO(), "you will find nothing");
	$this->assertCount(0, $mode);
}

	/**
	 * test grabbing all modes
	 **/

	public function testGetAllValidModes(){
	//count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("mode");

	//create a new mode and insert to into mySQL
	$mode = new Mode(null, $this->VALID_MODENAME);
	$mode->insert($this->getPDO());

	//grab the data from mySQL and enforce the fields match our expectations
	$results = Mode::getAllModes($this->getPDO());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("mode"));
	$this->assertCount(1, $results);
	$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Mode", $results);

	//grab the result from the array and validate it
	$pdoMode = $results[0];
	$this->assertEquals($pdoMode->getModeName(), $this->VALID_MODENAME);
	}

}