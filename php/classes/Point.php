<?php
namespace Edu\Cnm\SproutSwap;
require_once ("autoload.php");
/**
 * Point class for SproutSwap
 * Used by $postLocation
 * @author Noel Cothren <noelcothren@gmail.com>
 *
 */
class Point implements \JsonSerializable {
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
	public function __construct(float $newLat, float $newLong) {
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
	 * @return $lat
	 */
	public function getLat() {
		return ($this->lat);
	}

	/**
	 * mutator method for latitude
	 * @param float $newLat
	 * @throws \RangeException if $newLat is not between -180 and 180
	 */
	public function setLat($newLat) {
		if($newLat < -90 || $newLat > 90)
		{throw(new \RangeException("latitude is not within the range (-180,180)"));}
		$this->lat=$newLat;
}

	/**
	 * accessor method for longitude
	 * @param float $long
	 * @return $long
	 */
	public function getLong() {
		return($this->long);
	}
	/**
	 * mutator method for latitude
	 * @param float $newLong
	 * @throws \RangeException if $newLat is not between -90 and 90
	 */
	public function setLong($newLong) {
		if($newLong < -180 || $newLong > 180)
		{throw(new \RangeException("longitude is not within the range (-90, 90)"));}
		$this->long=$newLong;
	}

	/**
	 *insert this point into mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) {
		if($this->lat !== null || $this->long !== null) {
			throw(new \PDOException("not a new location"));
		}
		$query = "INSERT INTO point(lat, long) VALUES(:lat, :long)";
		$statement = $pdo->prepare($query);
		$parameters = ["lat" => $this->lat, "long" =>$this->long];
		$statement->execute($parameters);
	}
	/**
 *update a point object in mySQL
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 */
	public function update(\PDO $pdo) {
		if($this->lat === null || $this->long === null) {
			throw(new \PDOException("cannot update a non-existant point"));
		}
		$query = "UPDATE point SET lat = :lat, long = :long";
		$statement = $pdo->prepare($query);
		$parameters = ["lat" => $this->lat, "long" =>$this->long];
		$statement->execute($parameters);
	}
	/**
	 *delete a point object from mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo) {
		if($this->lat === null || $this->long === null) {
			throw(new \PDOException("cannot delete a non-existant point"));
		}
		$query = "DELETE FROM point WHERE lat = :lat";
		$statement = $pdo->prepare($query);
		$parameters = ["lat" => $this->lat, "long" =>$this->long];
		$statement->execute($parameters);
	}
	public function JsonSerialize() {
		$fields = [];
		$fields["lat"] = $this->lat;
		$fields["long"] = $this->long;
		return($fields);
	}
}
