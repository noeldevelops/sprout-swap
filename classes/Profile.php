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
}
