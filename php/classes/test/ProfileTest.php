<?php
namespace Edu\Cnm\SproutSwap\Test;

//grab project test
use Edu\Cnm\SproutSwap\{Profile, ValidateDate};
require_once("SproutSwapTest.php");

//grab the profile class
require_once (dirname(__DIR__). "/autoload.php");

//author Zak Abad <abad.zacaria@gmail.com>;

class ProfileTest extends SproutSwapTest {
	use ValidateDate;
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
		$this->profile = new Profile(null, 764736, "T0lwOTmIAh251cgB", "solomon.leyba@gmail.com", "twentyone", $this->VALID_PROFILEDATE, "solomon", "lOWXvPlng4ylCv10huXXzsjyCA0UwIluquBYwVeDzjOyffUm1uUHzB5r1FnlvL0C", "TMFNmjsZeb3qxmL6TmPrQvU65M7N66RQAS9U94gq792mis8R4We36OySAXJsBISP", "skgflashgfjahsdg summary");
		$this->profile->insert($this->getPDO());

		//calculate the date (just use the time the unit test was setup...)
		$this->VALID_PROFILEDATE = new \DateTime();
	}
	/**
	 * test inserting a valid Profile and verify that the actual mySQL data matches
	 **/

	public function testInsertValidProfile(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->profile->getProfileId(), $this->VALID_PROFILECONTENT, $this->VALID_PROFILEDATE);
		$profile->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
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
		$profile = new Profile(SproutSwapTest::INVALID_KEY, $this->profile->getProfileId(), $this->VALID_PROFILECONTENT, $this->VALID_PROFILEDATE);
		$profile->update($this->getPDO());
	}

	/**
	 * test inserting a Profile, editing it, and then updating it
	 **/

	public function testUpdateValidProfile() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->profile->getProfileId(), $this->VALID_PROFILECONTENT, $this->VALID_PROFILEDATE);
		$profile->insert($this->getPDO());

		//edit the Profile and update it in mySQL
		$profile->setProfileContent($this->VALID_PROFILECONTENT2);
		$profile->update($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileNameByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $this->profile->getProfikeId());
		$this->assertEquals($pdoProfile->getProfileContent(), $this->VALID_PROFILECONTENT2);
		$this->assertEquals($pdoProfile->getProfileDate(), $this->VALID_PROFILEDATE);
		}

	/**
	 * test updating a Profile that does not exist
	 *
	 * @expectedException PDOException
	 **/

	public function testUpdateInvalidProfile(){
		//create a Profile, try to update it without actually updating it and watch it fail
		$mode = new Profile(null, $this->profile->getProfileId(), $this->VALID_PROFILECONTENT, $this->VALID_PROFILEDATE);
		$this->update($this->getPDO());
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
		//create a Profile and try to delete it without actually inserting it
		$profile = new Profile(null, $this->profile->getProfileId(), $this->VALID_PROFILECONTENT, $this->VALID_PROFILEDATE);
		$profile->delete($this->getPDO());
	}

	/**
	 * test grabbing a Profile by profile content
	 **/

	public function testGetValidProfileByContent(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->profile->getProfileId(), $this->VALID_PROFILECONTENT, $this->VALID_PROFILEDATE);
		$profile->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Profile::getProfileByProfileContent($this->getPDO(), $profile->getProfileContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Zabad1\\SproutSwap\\Profile", $results);

		//grab the result from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($pdoProfile->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileContent(), $this->VALID_PROFILECONTENT);
		$this->assertEquals($pdoProfile->getProfileDate(), $this->VALID_PROFILEDATE);
	}

	/**
	 * test grabbing a Profile by content that does not exist
	 **/

	public function testGetInvalidProfileByContent(){
		//grab profile by searching for content that does not exist
		$profile = Profile::getProfileByProfileContent($this->getPDO(), "you will find nothing");
		$this->assertCount(0, $profile);
	}

	/**
	 * test grabbing all profiles
	 **/

	public function testGetAllValidProfiles(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new profile and insert to into mySQL
		$profile = new Profile(null, $this->profile->getProfileId(), $this->VALID_PROFILECONTENT, $this->VALID_PROFILEDATE);
		$profile->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Profile::getAllProfiles($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Zabad1\\SproutSwap\\Profile", $results);

		//grab the result from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($pdoProfile->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileContent(), $this->VALID_PROFILECONTENT);
		$this->assertEquals($pdoProfile->getProfileDate(), $this->VALID_PROFILEDATE);
}

}
?>
