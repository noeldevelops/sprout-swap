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

	public function setModeId(int $newModeId = null){
		if ($newModeId === null){
			$this->modeId = null;
			return;
		}
		if ($newModeId <= 0){
			throw (new \RangeException("Mode Id must be positive"));
		}

		/**
		 * accessor method for Mode Id
		 * @return int $modeId
		 **/


	}
}