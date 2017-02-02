<?php
namespace Edu\Cnm\SproutSwap\Test;

//grab project test
use

use Edu\Cnm\SproutSwap\DataDesign\Test\DataDesignTest;use Edu\Cnm\SproutSwap\Profile;require_once("DataDesignTest.php");

//grab the profile class
require_once (dirname(__DIR__)). "/autoload.php";

@author Zak Abad <abad.zacaria@gmail.com>

class ProfileTest extends DataDesignTest {
	/**
	 * content for profile
	 * @var string $VALID_PROFILECONTENT
	 **/
	protected $VALID_PROFILECONTENT = "PHPUnit test passing";
	/**
	 * content for the updated Profile
	 * @var string $VALID_PROFILECONTENT2
	 **/
	protected $VALID_PROFILECONTENT2 = "PHPUnit test still passing";
	/**
	 * timestamp of the profile; this starts as null and is assigned later
	 * @var DateTime $VALID_PROFILEDATE
	 **/
	protected $VALID_PROFILEDATE = null;
	/**
	 * Profile that created the Profile; this is for foreign key relations
	 * @var Profile profile
	 **/
	protected $profile = null;
	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp(){
		//run the default setUp() method first
		parent::setUp();

		//create and insert a Profile to the own test to Profile
		$this->profile = new Profile(null, "@phpunit", "test@phpunit.de", "+12125551212");
		$this->profile->insert($this->getPDO());

		//calculate the date (just use the time the unit test was setup...)
		$this->VALID_PROFILEDATE = new \DateTime();
	}
	/**
	 * test inserting a valid Profile and verify that the actual mySQL data matches
	 **/

	public function testInsertValidProfile(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");.

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->profile->getProfileId(), $this->VALID_PROFILECONTENT, $this->VALID_PROFILEDATE);
		$profile->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expections
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileContent(), $this->VALID_PROFILECONTENT);
		$this->assertEquals($pdoProfile->getProfileDate(), $this->VALID_PROFILEDATE);
	}

	/**
	 * test inserting a Profile that already exists
	 *
	 * @expectedException PDOException
	 **/

	public function testInsertInvalidProfile(){
		//create a Profile with a non null profile id and watch it fail
		$profile = new Profile(DataDesignTest::INVALID_KEY, $this->profile->getProfileId(), $this->VALID_PROFILECONTENT, $this->VALID_PROFILEDATE);
		$profile->update($this->getPDO());
	}

	/**
	 * test creating a Profile and then deleting it
	 **/

	public function testDeleteValidProfile(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->profile->getProfileId(), $this->VALID_PROFILECONTENT, $this->VALID_PROFILEDATE);
		$profile->insert($this->getPDO());

		//delete the profile from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$profile->delete($this->getPDO());

		//grab the data from mySQL and enforce the Profile does not exist
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertNull($pdoProfile);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
	}

	/**
	 * test deleting a Profile that does not exist
	 *
	 * @expectedException PDOException
	 **/

	public function testDeleteInvalidProfile(){
		//create a Profile
	}
};
