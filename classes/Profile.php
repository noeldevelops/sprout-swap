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
	 * @var char(16) for $profileActivation
	 **/
	private $profileActivation;
	/**
	 *user private access email
	 * @var varchar(255) for $profileEmail;
	 **/
	private $profileEmail;
	/**
	 * created by the user; has to be unique
	 * @var varchar(21) is for $profileHandlie not null
	 **/
	private $profileHandle;
	/**
	 *timestamp will be created in sql database when profile is created
	 * @var timestamp default current_timestamp not null
	 **/
	private $profileTimestamp;
	/**
	 * profileName will be end users real name
	 * @var varchar(30) for $profileName
	 **/
	private $profileName;
	/**
	 * database will generate a hash value
	 * @var char(64) for $profilePasswordHash
	 **/
	private $profilePasswordHash;
	/**
	 * salt created by password hash
	 * @var char(64) for $profileSalt
	 **/
	private $profileSalt;
	/**
	 * description of the profile
	 * @var varchar(255) for $profileSummary
	 **/
	private $profileSummary;

	public function_construct(int $newProfileId = null, int $newProfileImageId, char $newProfileActivation, varchar $newProfileEmail, varchar $newProfileHandle, timestamp default $newProfileTimestamp, varchar $newProfileName, char $newProfilePasswordHash, char $newProfileSalt, varchar $newProfileSummary) {
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
	 * @param char $newProfileActivation
	 * @throws \RangeException is profile activation is not positive
	 * @thorws \TypeError if $newProfileActivation is not a char
	 **/
}
