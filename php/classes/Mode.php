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
}