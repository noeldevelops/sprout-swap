<?php

class Profile {
	/**
	 * id for the profile; this is a primary key
	 * @var int for $profileId
	 **/
	private $profileId;
	/**
	 * id for profileImageId
	 * this is a foreign key that references image (imageId)
	 * @var int $profileImageId
	 **/
	private $profileImageId;
	/**
	 * activation code will be sent to end users email
	 * @var $profileActivation string (16)
	 **/
	private $profileActivation;
	/**
	 *user private access email
	 * @var $profileEmail string (255);
	 **/
	private $profileEmail;
	/**
	 * created by the user; has to be unique
	 * @var $profileHandlie string (21) not null
	 **/
	private $profileHandle;
	/**
	 *timestamp will be created in sql database when profile is created
	 * @var timestamp default current_timestamp not null
	 **/
	private $profileTimestamp;
	/**
	 * profileName will be end users real name
	 * @var $profileName string (30)
	 **/
	private $profileName;
	/**
	 * database will generate a hash value
	 * @var $profilePasswordHash string (64)
	 **/
	private $profilePasswordHash;
	/**
	 * salt created by password hash
	 * @var $profileSalt string (64)
	 **/
	private $profileSalt;
	/**
	 * description of the profile
	 * @var $profileSummary string (255)
	 **/
	private $profileSummary;

	public function __construct(int $newProfileId = null, int $newProfileImageId, string $newProfileActivation, string $newProfileEmail, string $newProfileHandle, $newProfileTimestamp = null, string $newProfileName, string $newProfilePasswordHash, string $newProfileSalt, string $newProfileSummary) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileImageId($newProfileImageId);
			$this->setProfileActivation($newProfileActivation);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileHandle($newProfileHandle);
			$this->setProfileTimestamp($newProfileTimestamp);
			$this->setProfileName($newProfileName);
			$this->setProfilePasswordHash($newProfilePasswordHash);
			$this->setProfileSalt($newProfileSalt);
			$this->setProfileSummary($newProfileSummary);
	} catch(\InvalidArgumentException $invaildArgument) {
	throw(new \InvalidArgumentException($invaildArgument->getmessage(), 0, $invaildArgument));
		} catch(\RangeException $rangeException) {
			throw (new \RangeException($rangeException->getMessage(), 0, $rangeException));
		} catch(\TypeError $typeError) {
			throw (new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			throw (new \Exception($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for messageId
	 * @return int|null value of messageId
	 **/
	public function getProfileId() {
		return($this->profileId);
	}
	/**
	 * mutator method for profile id
	 * @param int|null $newProfileId
	 * @throws \RangeException is profile id is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 **/

	public function setProfileId(int $newProfileId = null) {
		if($newProfileId === null) {
			$this->profileId = null;
			return;
		}
		if($newProfileId <= 0) {
			throw (new \RangeException("Profile Id must be positive"));
		}
		//convert and store profile id
	$this->profileId = $newProfileId;
	}
	/**
	 * accessor method for Profile Id
	 * @return int $profileImageId
	 **/

		public function getProfileImageId() {
	return($this->profileImageId);
}
	/**
	 * mutator method for profile image id
	 * @param int|null $newProfileImageId
	 * @throws \RangeException is profile image id is not positive
	 * @thorws \TypeError if $newProfileImageId is not an integer
	 **/

		public function setProfileImageId(int $newProfileImageId = null) {
	if($newProfileImageId === null) {
		$this->profileImageId = null;
		return;
	}
	if($newProfileImageId <= 0) {
		throw (new \RangeException("Profile Image Id must be positive"));
	}
	//convert and store profile image id
	$this->profileImageId = $newProfileImageId;
}
	/**
	 * accessor method for Profile Image Id
	 * @return int $profileActivation
	 **/

	public function getProfileActivation() {
	return($this->profileActivation);
}
	/**
	 * mutator method for profile activation
	 * @param string $newProfileActivation
	 * @throws \InvalidArgumentException if $newProfileActivation is insecure
	 * @throws \RangeException if $newProfileActivation is > 16 characters
	 * @thorws \TypeError if $newProfileActivation is not a string
	 **/

	public function setProfileActivation(string $newProfileActivation) {
		if(empty($newProfileActivation) === true) {
			throw(new \InvalidArgumentException("profile activation is empty or insecure"));
		}
		if(strlen($newProfileActivation) > 16){
			throw(new \RangeException("profile activation cannot be more than 16 characters"));
		}
			$this->profileActivation = $newProfileActivation;
	}
	/**
	 * accessor method for profile activation
	 *
	 * @return \Profile activation valid for profile
	 **/

	public function getProfileEmail() {
		return($this->profileEmail);
	}

	/**
	 * mutator method for profile email
	 * @param int $newProfileEmail
	 * @throws \RangeException if $newProfileEmail is not positive
	 * @throws \TypeError if $newProfileEmail is not a string
	 **/

	public function setProfileEmail(string $newProfileEmail) {
		if(empty($newProfileEmail) === true){
			throw(new \InvalidArgumentException("Must have email address"));
		}
		if(strlen($newProfileEmail) > 255){
			throw(new \RangeException("Email cannot contain more than 255 characters"));
		}
		$this ->profileEmail = $newProfileEmail;

	}
	/**
	 * accessor method for profile email
	 * @return string
	 */

	public function getProfileHandle() {
		return($this->profileHandle);
	}

	/**
	 * mutator method for profile handle
	 * @param int $newProfileHandle
	 * @throws \RangeException if $newProfileHnadle is not positive
	 * @throws \TypeError if $newProfileHandle is not a string
	 **/

	public function setProfileHandle(string $newProfileHandle) {
		if(empty($newProfileHandle) === true){
			throw(new \InvalidArgumentException("must create unique profile handle"));
		}
		if(strlen($newProfileHandle) > 21){
			throw(new \RangeException("Profile handle cannot contain more than 21 characters"));
		}
		$this->profileHandle = $newProfileHandle;
	}
	/**
	 * accessor method for profile handle
	 * @return string
	 **/

	public function getProfileTimestamp() {
		return($this->profileTimestamp);
	}

	/**
	 * mutator method for profile timestamp
	 * @param null $newProfileTimestamp
	 **/

	public function setProfileTimestamp($newProfileTimestamp = null){
		if($newProfileTimestamp === null){
			$this->profileTimestamp = new DateTime();
			return;
		}
		try{
			$newProfileTimestamp = self::validatetime($newProfileTimestamp);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw (new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $rangeException) {
				throw (new \RangeException($rangeException->getmessage(), 0, $rangeException));
			}
		$this->profileTimestamp = $newProfileTimestamp;
		}

		/** accessor method for profile timestamp
		 *@return $this profile timestamp
		 **/

	public function getProfileName() {
		return($this->profileName);
	}

	/**
	 * mutator method for profile name
	 * @param int $newProfileName
	 * @throws \RangeException if $newProfileName is not positive
	 * @throws \TypeError if $newProfileName is not a string
	 **/

	public function setProfileName(string $newProfileName){
		if(empty($newProfileName) === true){
			throw(new \InvalidArgumentException("profile name must be a first and last name"));
		}
		if(strlen($newProfileName) > 30){
			throw(new \RangeException("profile name cannot contain more than 30 characters"));
		}
		$this->profileName = $newProfileName;
	}
	/**
	 * accessor method for profile name
	 * @return string
	 **/

	public function getProfilePasswordHash(){
		return($this->profilePasswordHash);
	}

	/**
	 * mutator method for profile password hash
	 * @param int $newProfilePasswordHash
	 * @throws \RangeException if $newPrfofilePasswordHash is not positive
	 * @throws \TypeError if $newProfilePasswordHash is not a string
	 **/

	public function setProfilePasswordHash(string $newProfilePasswordHash){
		if(empty($newProfilePasswordHash) === true){
			throw(new \InvalidArgumentException("profile passwordhash will be created in the string"));
		}
		if(strlen($newProfilePasswordHash) > 128){
			throw(new \RangeException("profile password hash cannot contain more than 128 characters"));
		}
		$this->profilePasswordHash = $newProfilePasswordHash;
	}

	/**
	 * accessor method for profile password hash
	 * @return string
	 **/

	public function getProfileSalt(){
		return($this->profileSalt);
	}

	/**
	 * mutator method for profile salt
	 * @param int $newProfileSalt
	 * @throws \RangeException if $newProfileSalt is not positive
	 * @throws \TypeError if $newProfileSalt is not a string
	 **/

	public function setProfileSalt(string $newProfileSalt){
		if(empty($newProfileSalt) === true){
			throw(new \InvalidArgumentException("profile salt created by hash"));
		}
		if(strlen($newProfileSalt) > 64){
			throw(new \RangeException("profile salt cannot contain more than 64 characters"));
		}
		$this->profileSalt = $newProfileSalt;
	}

	/**
	 * accessor method for profile salt
	 * @return string
	 **/

	public function getProfileSummary(){
		return($this->profileSummary);
	}

	/**
	 * mutator method for profile summary
	 * @param int $newProfileSummary
	 * @throws \RangeException if $newProfileSummary is not positive
	 * @throws \TypeError if $newProfileSummary is not a string
	 **/

	public function setProfileSummary(string $newProfileSummary) {
		if(empty($newProfileSummary) === true) {
			throw(new \InvalidArgumentException(("profile summary created by user")));
		}
		if(strlen($newProfileSummary) > 255) {
			throw(new \RangeException("profile summary cannot contain more than 255 characters"));
		}
		$this->profileSummary = $newProfileSummary;

	}
	/**
	 * accessor method for profile summary
	 * @return string
	 **/


}
