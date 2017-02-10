<?php
namespace Edu\Cnm\SproutSwap\Test;

//grab project test
use Edu\Cnm\SproutSwap\{
	Profile, ValidateDate, Image
};

require_once("SproutSwapTest.php");

//grab the profile class
require_once(dirname(__DIR__) . "/autoload.php");

//author Zak Abad <abad.zacaria@gmail.com>;

class ProfileTest extends SproutSwapTest {
	/**
	 * valid profile activation is the variable
	 * @var string $VALID_PROFILEACTIVATION
	 **/
	protected $VALID_PROFILEACTIVATION = "khemfpilcgwqukla";
	/**
	 * valid proilfe email is the variable
	 * @var string $VALID_PROFILEEMAIL
	 **/
	protected $VALID_PROFILEEMAIL = "TRUMPH@TINYHANDS.RU";
	/**
	 * valid profile handle
	 * @var string $VALID_PROFILEHANDLE
	 **/
	protected $VALID_PROFILEHANDLE = "SMURFTRUMP";
	/**
	 * valid profile name
	 * @var string $VALID_PROFILENAME
	 **/
	protected $VALID_PROFILENAME = "DONNYT";
	/**
	 * image
	 * @var Image $image
	 **/
	public $image = null;
	/**
	 * valid profile hash
	 * @var null $VALID_PROFILEHASH
	 **/
	protected $VALID_PROFILEHASH = null;
	/**
	 * valid profile salt
	 * @var null $VALID_PROFILESALT
	 **/
	protected $VALID_PROFILESALT = null;
	/**
	 * content for profile
	 * @var string $VALID_PROFILESUMMARY
	 **/
	protected $VALID_PROFILESUMMARY = "PHPUnit test passing";
	/**
	 * content for the updated Profile
	 * @var string $VALID_PROFILESUMMARY2
	 **/
	protected $VALID_PROFILESUMMARY2 = "PHPUnit test still passing";
	/**
	 * timestamp of the profile; this starts as null and is assigned later
	 * @var \DateTime $VALID_PROFILEDATE
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
	public final function setUp() {
		//run the default setUp() method first
		parent::setUp();

		//create and insert a image to the own test to Image
		$this->image = new Image(null, "764736");
		$this->image->insert($this->getPDO());

		//calculate the date (just use the time the unit test was setup...)
		$this->VALID_PROFILEDATE = new \DateTime();

		//creating salt and hash
		$password = "123";
		$this->VALID_PROFILESALT = bin2hex(random_bytes(16));
		$this->VALID_PROFILEHASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILESALT, 262144);
	}

	/**
	 * test inserting a valid Profile and verify that the actual mySQL data matches
	 **/

	public function testInsertValidProfile() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");


		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->image->getImageId(), $this->VALID_PROFILEACTIVATION, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEDATE, $this->VALID_PROFILENAME, $this->VALID_PROFILEHASH, $this->VALID_PROFILESALT, $this->VALID_PROFILESUMMARY);
		$profile->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileSummary(), $this->VALID_PROFILESUMMARY);
		$this->assertEquals($pdoProfile->getProfileId(), $profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileTimestamp(), $this->VALID_PROFILEDATE);
	}

	/**
	 * test inserting a Profile that already exists
	 *
	 * @expectedException \PDOException
	 **/

	public function testInsertInvalidProfile() {
		//create a Profile with a non null profile id and watch it fail
		$profile = new Profile(SproutSwapTest::INVALID_KEY, $this->image->getImageId(), $this->VALID_PROFILEACTIVATION, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEDATE, $this->VALID_PROFILENAME, $this->VALID_PROFILEHASH, $this->VALID_PROFILESALT, $this->VALID_PROFILESUMMARY);
		$profile->insert($this->getPDO());
	}

	/**
	 * test inserting a Profile, editing it, and then updating it
	 **/

	public function testUpdateValidProfile() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->image->getImageId(), $this->VALID_PROFILEACTIVATION, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEDATE, $this->VALID_PROFILENAME, $this->VALID_PROFILEHASH, $this->VALID_PROFILESALT, $this->VALID_PROFILESUMMARY);
		$profile->insert($this->getPDO());

		//edit the Profile and update it in mySQL
		$profile->setProfileSummary($this->VALID_PROFILESUMMARY2);
		$profile->update($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profile->getProfileId());
		$this->assertEquals(
			$profile->getProfileSummary(), $this->VALID_PROFILESUMMARY2);
		$this->assertEquals($pdoProfile->getProfileTimestamp(), $this->VALID_PROFILEDATE);
	}

	/**
	 * test updating a Profile that does not exist
	 *
	 * @expectedException \PDOException
	 **/

	public function testUpdateInvalidProfile() {
		//create a Profile, try to update it without actually updating it and watch it fail
		$profile = new Profile(null, $this->image->getImageId(), $this->VALID_PROFILEACTIVATION, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEDATE, $this->VALID_PROFILENAME, $this->VALID_PROFILEHASH, $this->VALID_PROFILESALT, $this->VALID_PROFILESUMMARY);
		$profile->update($this->getPDO());
	}

	/**
	 * test creating a Profile and then deleting it
	 **/

	public function testDeleteValidProfile() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->image->getImageId(), $this->VALID_PROFILEACTIVATION, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEDATE, $this->VALID_PROFILENAME, $this->VALID_PROFILEHASH, $this->VALID_PROFILESALT, $this->VALID_PROFILESUMMARY);
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
	 * @expectedException \PDOException
	 **/

	public function testDeleteInvalidProfile() {
		//create a Profile and try to delete it without actually inserting it
		$profile = new Profile(null, $this->image->getImageId(), $this->VALID_PROFILEACTIVATION, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEDATE, $this->VALID_PROFILENAME, $this->VALID_PROFILEHASH, $this->VALID_PROFILESALT, $this->VALID_PROFILESUMMARY);
		$profile->delete($this->getPDO());
	}

	/**
	 * test grabbing a Profile by profile image id
	 **/

	public function testGetValidProfileByImageId() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->image->getImageId(), $this->VALID_PROFILEACTIVATION, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEDATE, $this->VALID_PROFILENAME, $this->VALID_PROFILEHASH, $this->VALID_PROFILESALT, $this->VALID_PROFILESUMMARY);
		$profile->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Profile::getProfileByProfileImageId($this->getPDO(), $profile->getProfileImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Profile", $results);

		//grab the result from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($pdoProfile->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileSummary(), $this->VALID_PROFILESUMMARY);
		$this->assertEquals($pdoProfile->getProfileDate(), $this->VALID_PROFILEDATE);
	}

	/**
	 * test grabbing a Profile by profile activation
	 **/

	public function testGetValidProfileByActivation() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->image->getImageId(), $this->VALID_PROFILEACTIVATION, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEDATE, $this->VALID_PROFILENAME, $this->VALID_PROFILEHASH, $this->VALID_PROFILESALT, $this->VALID_PROFILESUMMARY);
		$profile->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Profile::getProfileByProfileActivation($this->getPDO(), $profile->getProfileActivation());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Profile", $results);

		//grab the result from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($pdoProfile->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileSummary(), $this->VALID_PROFILESUMMARY);
		$this->assertEquals($pdoProfile->getProfileDate(), $this->VALID_PROFILEDATE);
	}

	/**
	 * test grabbing a Profile by activation that does not exist
	 **/

	public function testGetInvalidProfileByActivation() {
		//grab profile by searching for activation that does not exist
		$profile = Profile::getProfileByProfileActivation($this->getPDO(), "you will find nothing");
		$this->assertCount(0, $profile);
	}

	/**
	 * test grabbing a Profile by profile email
	 **/

	public function testGetValidProfileByEmail() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->image->getImageId(), $this->VALID_PROFILEACTIVATION, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEDATE, $this->VALID_PROFILENAME, $this->VALID_PROFILEHASH, $this->VALID_PROFILESALT, $this->VALID_PROFILESUMMARY);
		$profile->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Profile::getProfileByProfileEmail($this->getPDO(), $profile->getProfileEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Profile", $results);

		//grab the result from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($pdoProfile->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileSummary(), $this->VALID_PROFILESUMMARY);
		$this->assertEquals($pdoProfile->getProfileDate(), $this->VALID_PROFILEDATE);
	}

	/**
	 * test grabbing a Profile by email that does not exist
	 **/

	public function testGetInvalidProfileByEmail() {
		//grab profile by searching for email that does not exist
		$profile = Profile::getProfileByProfileEmail($this->getPDO(), "you will find nothing");
		$this->assertCount(0, $profile);
	}

	/**
	 * test grabbing a Profile by profile handle
	 **/

	public function testGetValidProfileByHandle() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->image->getImageId(), $this->VALID_PROFILEACTIVATION, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEDATE, $this->VALID_PROFILENAME, $this->VALID_PROFILEHASH, $this->VALID_PROFILESALT, $this->VALID_PROFILESUMMARY);
		$profile->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Profile::getProfileByProfileHandle($this->getPDO(), $profile->getProfileHandle());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Profile", $results);

		//grab the result from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($pdoProfile->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileSummary(), $this->VALID_PROFILESUMMARY);
		$this->assertEquals($pdoProfile->getProfileDate(), $this->VALID_PROFILEDATE);
	}

	/**
	 * test grabbing a Profile by handle that does not exist
	 **/

	public function testGetInvalidProfileByHandle() {
		//grab profile by searching for handle that does not exist
		$profile = Profile::getProfileByProfileHandle($this->getPDO(), "you will find nothing");
		$this->assertCount(0, $profile);
	}

	/**
	 * test grabbing a Profile by profile name
	 **/

	public function testGetValidProfileByName() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->image->getImageId(), $this->VALID_PROFILEACTIVATION, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEDATE, $this->VALID_PROFILENAME, $this->VALID_PROFILEHASH, $this->VALID_PROFILESALT, $this->VALID_PROFILESUMMARY);
		$profile->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Profile::getProfileByProfileName($this->getPDO(), $profile->getProfileName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Profile", $results);

		//grab the result from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($pdoProfile->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileSummary(), $this->VALID_PROFILESUMMARY);
		$this->assertEquals($pdoProfile->getProfileDate(), $this->VALID_PROFILEDATE);
	}

	/**
	 * test grabbing a Profile by name that does not exist
	 **/

	public function testGetInvalidProfileByName() {
		//grab profile by searching for name that does not exist
		$profile = Profile::getProfileByProfileName($this->getPDO(), "you will find nothing");
		$this->assertCount(0, $profile);
	}
	/**
	 * test grabbing a Profile by profile summary
	 **/

	public function testGetValidProfileBySummary() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->image->getImageId(), $this->VALID_PROFILEACTIVATION, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEDATE, $this->VALID_PROFILENAME, $this->VALID_PROFILEHASH, $this->VALID_PROFILESALT, $this->VALID_PROFILESUMMARY);
		$profile->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Profile::getProfileByProfileSummary($this->getPDO(), $profile->getProfileSummary());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Profile", $results);

		//grab the result from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($pdoProfile->getProfileId(), $profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileSummary(), $this->VALID_PROFILESUMMARY);
		$this->assertEquals($pdoProfile->getProfileTimestamp(), $this->VALID_PROFILEDATE);
	}

	/**
	 * test grabbing a Profile by summary that does not exist
	 **/

	public function testGetInvalidProfileBySummary() {
		//grab profile by searching for summary that does not exist
		$profile = Profile::getProfileByProfileSummary($this->getPDO(), "you will find nothing");
		$this->assertCount(0, $profile);
	}

	/**
	 * test grabbing all profiles
	 **/

	public function testGetAllValidProfiles() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new profile and insert to into mySQL
		$profile = new Profile(null, $this->image->getImageId(), $this->VALID_PROFILEACTIVATION, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEDATE, $this->VALID_PROFILENAME, $this->VALID_PROFILEHASH, $this->VALID_PROFILESALT, $this->VALID_PROFILESUMMARY);
		$profile->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Profile::getAllProfiles($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\SproutSwap\\Profile", $results);

		//grab the result from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($pdoProfile->getProfileId(), $profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileSummary(), $this->VALID_PROFILESUMMARY);
		$this->assertEquals($pdoProfile->getProfileTimestamp(), $this->VALID_PROFILEDATE);
	}

}

