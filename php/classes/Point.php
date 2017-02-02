<?php
namespace Edu\Cnm\SproutSwap
/**
 * Point class for SproutSwap
 * @author Noel Cothren <noelcothren@gmail.com>
 *
 */
class Point implements JsonSerializable {
/**
 * @var float $lat latitude
 *
 */
private $lat;
/**
 * @var float $long longitude
 */
private $long;
/**
 * constructor for the Point object
 * @param $newLat
 * @param $newLong
 * @throws \InvalidArgumentException if not valid
 */
public function __construct($newLat, $newLong) {
	try {
		$this->setLat($newLat);
		$this->setLong($newLong);
	} catch(\InvalidArgumentException $invalidArgumentException) {
		throw(new \InvalidArgumentException("not a valid location"));
	}
}
/**
 * accessor method for latitude
 * @param float $lat
 */
public function getLat() {
	return($this->lat);
}
/**
 * mutator method for latitude
 * @param float $newLat
 * @throws \RangeException if $newLat is not between -180 and 180
 */
public function setLat($newLat) {

}
}
