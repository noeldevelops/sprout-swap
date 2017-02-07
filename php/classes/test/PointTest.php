<?php
namespace Edu\Cnm\SproutSwap\Test;
use Edu\Cnm\SproutSwap\{Point};

require_once("SproutSwapTest.php");
require_once (dirname(__DIR__) . "/autoload.php");

/**
 * PHPUnit test for the Point container class used by Post
 * @see \Edu\Cnm\SproutSwap\Post
 * @author Solomon Leyba solomon.leyba@gmail.com
 */

class PointTest extends PHPUnit_Framework_TestCase {
	protected $VALID_LAT = 40.9384;
	protected $VALID_LONG = 50.2342;
	protected $INVALID_LAT = 100.4544;
	protected $INVALID_LONG = 200.6666;

	/**
	 * test using valid coordinates
	 */
	public function testValidPoint(){
		$point = new Point($this->VALID_LAT, $this->VALID_LONG);
		//use mutators to make a valid case
		$point->setLat($this->VALID_LAT);
		$point->setLong($this->VALID_LONG);
		//assert values are equal
		$this->assertEquals($point->getLat(), $this->VALID_LAT);
		$this->assertEquals($point->getLong(), $this->VALID_LONG);
	}
	/**
	 * test using invalid lat
	 */
	public function testInvalidPointLat(){
		$point = new Point($this->INVALID_LAT, $this->VALID_LONG);
		//use mutators to make an invalid case
		$point->setLat($this->INVALID_LAT);
		$point->setLong($this->VALID_LONG);
	}
	/**
	 * test using invalid long
	 */
	public function testInvalidPointLong(){
		$point = new Point($this->VALID_LAT, $this->INVALID_LONG);
		//use mutators to make an invalid case
		$point->setLat($this->VALID_LAT);
		$point->setLong($this->INVALID_LONG);
	}
}