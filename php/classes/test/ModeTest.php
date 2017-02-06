<?php
namespace Edu\Cnm\SproutSwap\Test;

//grab project test

Edu\Cnm\SproutSwap\Test\SproutSwapTest;
require_once("SproutSwapTest.php");

//grab the mode class
require_once (dirname(__DIR__)). "/autoload.php";

//author Zak Abad <abad.zacaria@gmail.com>

class ModeTest extends SproutSwapTest{
	/**
	 * content for modeId
	 * @var int modeId
	 **/
	protected $VALID_MODECONTENT = "PHPUnit test passing";
	/**
	 * content for updated Mode
	 * @var string $VALID_MODECONTENT2
	 **/
	protected $VALID_MODECONTENT2 = "PHPUnit test still passing";
	/**
	 * timestamp of the mode; this starts as null and is assigned later
	 * @var DateTime $VALID_MODEDATE
	 **/
	protected $VALID_MODEDATE = null;
	/**
	 * Profile that created the Mode; this is for foreign key relations
	 * @var Mode mode
	 **/
	protected $mode = null;
	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp(){
		//run the default seUp() method first
		parent::setUp();

		//create and insert a Profile to the own test to Mode
		$this->mode = new Mode(null, "@phpunit", "test@phpunit.de", "12125551212");
		$this->mode->insert($this->getPDO());

		//calculate the date (just use the time the unit test was setup...)
		$this->VALID_MODEDATE = new \DateTime();
	}
	/**
	 * test inserting a valid Mode and verify that the actual mySQL data matches
	 **/

	public function testInsertValidProfile(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("mode");

		//create a new Mode and insert to into mySQL
		$mode = new Mode(null, $this->mode->getModeId(), $this->VALID_MODECONTENT, $this->VALID_MODEDATE);
		$mode->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoMode = Mode::getModeNameByModeId($this->getPDO(), $mode->getModeId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("mode"));
		$this->assertEquals($pdoMode->getModeId(), $this->mode->getModeId());
		$this->assertEquals($pdoMode->getModeContent(), $this->VALID_MODECONTENT);
		$this->assertEquals($pdoMode->getModeDate(), $this->VALID_MODEDATE);
	}

	/**
	 * test inserting a Mode that already exists
	 *
	 * @expectedException PDOException
	 **/

	public function testInsertInvalidMode(){
		//create a Mode with a non null mode id and watch it fail
		$mode = new Mode(SproutSwapTest::INVALID_KEY, $this->mode->getModeId(), $this->VALID_MODECONTENT, $this->getPDO());
	}

	/**
	 * test test inserting a Profile, editing it, and then updating it
	 **/

	public function testUpdateValidMode(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("mode");

		//create a new Mode and insert to into mySQL
		$mode = new Mode(null, $this->mode->getModeId(), $this->VALID_MODECONTENT, $this->VALID_MODEDATE);
		$mode->insert($this->getPDO());

		//edit the Mode and update it in mySQL
		$mode->setModeContent($this->VALID_MODECONTENT2);
		$mode->update($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoMode = Mode::getModeNameByModeId($this->getPDO(), $mode->getModeId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("mode"));
		$this->assertEquals($pdoMode->getModeId(), $this->mode->getModeId());
		$this->assertEquals($pdoMode->getModeContent(), $this->VALID_MODECONTENT2);
		$this->assertEquals($pdoMode->getModeDate(), $this->VALID_MODEDATE);
	}

	/**
	 * test updating a Mode that does not exist
	 *
	 * @expectedException PDOException
	 **/

	public function testUpdateInvalidMode(){
		//create a Mode, try to update it without actually updating it and watch it fail
		$mode = new Mode(null, $this->mode->getModeId(), $this->VALID_MODECONTENT, $this->VALID_MODEDATE);
		$this->update($this->getPDO());
	}

	/**
	 * test creating a Mode and then deleting it
	 **/

	public function testDeleteValidMode(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("mode");

		//create a new Mode and insert to into mySQL
		$mode = new Mode(null, $this->mode->getModeId(), $this->VALID_MODECONTENT, $this->VALID_MODEDATE);
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
		$mode = new Mode(null, $this->mode->getModeId(), $this->VALID_MODECONTENT, $this->VALID_MODEDATE);
		$mode->delete($this->getPDO());
	}

	/**
	 * test grabbing a Mode by mode content
	 **/

	public function testGetValidModeByContent(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("mode");

		//create a new Mode and insert to into mySQL
		$mode = new Mode(null, $this->mode->getModeId(), $this->VALID_MODECONTENT, $this->VALID_MODEDATE);
		$mode->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Mode::getModeByModeContent($this->getPDO(), $mode->getModeContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("mode"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Zabad1\\DataDesign\\Mode", $results);

		//grab the result from the array and validate it
		$pdoMode = $results[0];
		$this->assertEquals($pdoMode->getModeId(), $this->mode->getModeId());
		$this->assertEquals($pdoMode->getModeContent(), $this->VALID_MODECONTENT);
		$this->assertEquals($pdoMode->getModeDate(), $this->VALID_MODEDATE);
	}

	/**
	 * test grabbing a Mode by content that does not exist
	 **/

	public function testGetInvalidModeByContent(){
		//grab mode by searching for content that does not exist
		$mode = Mode::getModeByModeContent($this->getPDO(), "you will find nothing");
		$this->assertCount(0, $mode);
	}

	/**
	 * test grabbing all modes
	 **/

	public function testGetAllValidModes(){
	//count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("mode");

	//create a new mode and insert to into mySQL
	$mode = new Mode(null, $this->mode->getModeId(), $this->VALID_MODECONTENT, $this->VALID_MODEDATE);
	$mode->insert($this->getPDO());

	//grab the data from mySQL and enforce the fields match our expectations
	$results = Mode::getAllModes($this->getPDO());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("mode"));
	$this->assertCount(1, $results);
	$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Zabad1\\SproutSwap\\Mode", $results);

	//grab the result from the array and validate it
	$pdoMode = $results[0];
	$this->assertEquals($pdoMode->getModeId(), $this->mode->getModeId());
	$this->assertEquals($pdoMode->getModeContent(), $this->VALID_MODECONTENT);
	$this->assertEquals($pdoMode->getModeDate(), $this->VALID_MODEDATE);
	}

}
?>