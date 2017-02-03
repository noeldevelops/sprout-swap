<?php
namespace Edu\Cnm\SproutSwap\Test;

//grab project test
use

use Edu\Cnm\SproutSwap\DataDesign\Test\DataDesignTest;use Edu\Cnm\SproutSwap\Mode;use Edu\Cnm\SproutSwap\Profile;require_once("DataDesignTest.php");

//grab the mode class
require_once (dirname(__DIR__)). "/autoload.php";

@author Zak Abad <abad.zacaria@gmail.com>

class ModeTest extends DataDesignTest{
	/**
	 * content for modeId
	 * @var int modeId
	 **/
	protected $VALID_MODECONTENT = "PHPUnit test passing";
	/**
	 * content for updated Mode
	 * @var string $VALID_PROFILECONTENT2
	 **/
	protected $VALID_MODECONTENT2 = "PHPUnit test still passing";
	/**
	 * timestamp of the mode; this starts as null and is assigned later
	 * @var DateTime $VALID_PROFILEDATE
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
		$mode = new Mode(DataDesignTest::INVALID KEY, $this->mode->getModeId(), $this->VALID_MODECONTENT, $this->getPDO());
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

	}
}