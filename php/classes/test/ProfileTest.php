<?php
namespace Edu\Cnm\SproutSwap\Test;

//grab project test
use

use Edu\Cnm\SproutSwap\DataDesign\Test\DataDesignTest;require_once("DataDesignTest.php");

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
	protected $VALID_PROFILECONTECT2 = "PHPUnit test still passing";
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

	}
};
