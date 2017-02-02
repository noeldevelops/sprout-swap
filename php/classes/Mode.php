<?php
namespace Edu\Cnm\SproutSwap;
/**
 * This class is what is stored when users create a new Profile
 *
 * @author A Zak Abad <abad.zacaria@gmail.com>
 * @version 1.0
 **/

class Mode{
	/**
	 * id for mode; this is the primary key
	 * @var int for modeId
	 **/
	private $modeId;
	/**
	 * mode name will appear when search for
	 * @var $modeName string (20)
	 **/
	private $modeName;

	public function __construct(int $newModeId = null, string $newModeName) {
	try {
		$this->setModeId($newModeId);
		$this->setModeName($newModeName);
	} catch(\InvalidArgumentException $invalidArgument) {
		throw (new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
	} catch(\RangeException $rangeException) {
		throw (new \RangeException($rangeException->getMessage(), 0, $rangeException));
	} catch(\TypeError $typeError) {
		throw (new \TypeError($typeError->getMessage(), 0, $typeError));
	} catch(\Exception $exception) {
		throw (new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for modeId
	 * @return int|null value of modeId
	 **/

	public function getModeId(){
		return ($this->modeId);
	}

	/**
	 * mutator method for mode id
	 * @param int|null $newModeId
	 * @throws \RangeException is mode id is not postive
	 * @throws \TypeError if $newModeId is not an integer
	 **/

	public function setModeId(int $newModeId = null) {
		if($newModeId === null) {
			$this->modeId = null;
			return;
		}
		if($newModeId <= 0) {
			throw (new \RangeException("Mode Id must be positive"));
		}

		/**
		 * accessor method for Mode Id
		 * @return int $modeId
		 **/
	}

	public function getModeName(){
		return ($this->modeName);
		}

		/**
		 * mutator method for mode name
		 * @param string $newModeName
		 * @throws \InvalidArgumentException if $newModeName is insecure
		 * @throws \RangeException if $newModeName is > 20 characters
		 * @throws \TypeError if $newModeName is not a string
		 **/

	public function setModeName(string $newModeName){
		if (empty($newModeName) === true){
			throw (new \InvalidArgumentException("mode name is empty or insecure"));
		}
		if (strlen($newModeName) > 20) {
			throw (new \RangeException("mode name cannot be more than 20 characters"));
		}
		$this->modeName = $newModeName;
	}

	/**
	 * accessor method for mode name
	 *
	 * @return \Mode name valid for mode
	 **/

	public function insert(\PDO $pdo){
		if($this->modeId !== null){
			throw(new \PDOException("not a new mode"));
		}
		$query = "INSERT INTO mode(modeId, modeName)";
		$statement = $pdo->prepare($query);
		$parameters = ["modeId" => $this->modeId, "modeName" => $this->modeName];
		$statement->execute($parameters);
		//update null modeId
		$this->modeId = intval($pdo->lastInsertId());
	}

	/**
	 * delete this mode from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function delete(\PDO $pdo){
		if($this->modeId === null){
			throw (new \PDOException("cannot delete mode id that does not exist"));
		}

		$query = "DELETE FROM mode WHERE modeId = modeId";
		$statement = $pdo->prepare($query);
		//bind the member varibles to the place holder in the template
		$parameters = ["modeId" => $this->modeId];
		$statement->execute($parameters);
	}

	/**
	 * update mode in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/


}