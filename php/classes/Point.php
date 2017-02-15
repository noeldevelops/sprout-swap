<?php
namespace Edu\Cnm\SproutSwap;

require_once ("autoload.php");

/**
 * Point class for SproutSwap
 * Used by Post class in variable $postLocation
 * @author Noel Cothren <noelcothren@gmail.com>
 **/
class Point implements \JsonSerializable {
	/**
	 * @var float $lat latitude
	 *
	 **/
	private $lat;
	/**
	 * @var float $long longitude
	 **/
	private $long;

	/**
	 * constructor for the Point object
	 * @param $newLat
	 * @param $newLong
	 * @throws \InvalidArgumentException if data types not valid
	 * @throws \RangeException if values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception for any other exception
	 */
	public function __construct(float $newLat, float $newLong) {
		try {
			$this->setLat($newLat);
			$this->setLong($newLong);
		} catch(\InvalidArgumentException $invalidArgumentException) {
			throw(new \InvalidArgumentException("not a valid location"));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for latitude
	 * @param float $lat
	 * @return float $lat value of latitude
	 **/
	public function getLat() {
		return ($this->lat);
	}

	/**
	 * mutator method for latitude
	 * @param float $newLat
	 * @throws \RangeException if $newLat is not between -180 and 180
	 **/
	public function setLat(float $newLat) {
		$newLat = $newLat == 0.0 ? 0.0 : filter_var($newLat, FILTER_VALIDATE_FLOAT);
		if($newLat === false) {
			throw(new \InvalidArgumentException("latitude is not a valid data type"));
		}
		if($newLat < -90 || $newLat > 90) {
			throw(new \RangeException("latitude is not within the range (-180,180)"));
		}
		$this->lat = $newLat;
}

	/**
	 * accessor method for longitude
	 * @param float $long
	 * @return float $long vlaue of longitude
	 */
	public function getLong() {
		return($this->long);
	}
	/**
	 * mutator method for latitude
	 * @param float $newLong
	 * @throws \RangeException if $newLat is not between -90 and 90
	 */
	public function setLong(float $newLong) {
		$newLong = $newLong == 0.0 ? 0.0 : filter_var($newLong, FILTER_VALIDATE_FLOAT);
		if($newLong === false) {
			throw(new \InvalidArgumentException("longitude is not a valid data type"));
		}
		if($newLong < -180 || $newLong > 180)
		{throw(new \RangeException("longitude is not within the range (-90, 90)"));}
		$this->long=$newLong;
	}
	public function JsonSerialize() {
		$fields = [];
		$fields["lat"] = $this->lat;
		$fields["long"] = $this->long;
		return($fields);
	}
}
