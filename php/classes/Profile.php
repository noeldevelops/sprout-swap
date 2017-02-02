<?php
namespace Edu\Cnm\SproutSwap;
/**
 * This class is what is stored when users create a new Profile
 *
 * @author A Zak Abad <abad.zacaria@gmail.com>
 * @version 1.0
 **/

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
	 * @var $profileHandle string (21) not null
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
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getmessage(), 0, $invalidArgument));
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
		return ($this->profileId);
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
		return ($this->profileImageId);
	}

	/**
	 * mutator method for profile image id
	 * @param int|null $newProfileImageId
	 * @throws \RangeException is profile image id is not positive
	 * @throws \TypeError if $newProfileImageId is not an integer
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
		return ($this->profileActivation);
	}

	/**
	 * mutator method for profile activation
	 * @param string $newProfileActivation
	 * @throws \InvalidArgumentException if $newProfileActivation is insecure
	 * @throws \RangeException if $newProfileActivation is > 16 characters
	 * @throws \TypeError if $newProfileActivation is not a string
	 **/

	public function setProfileActivation(string $newProfileActivation) {
		if(empty($newProfileActivation) === true) {
			throw(new \InvalidArgumentException("profile activation is empty or insecure"));
		}
		if(strlen($newProfileActivation) > 16) {
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
		return ($this->profileEmail);
	}

	/**
	 * mutator method for profile email
	 * @param int $newProfileEmail
	 * @throws \RangeException if $newProfileEmail is not positive
	 * @throws \TypeError if $newProfileEmail is not a string
	 **/

	public function setProfileEmail(string $newProfileEmail) {
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("Must have email address"));
		}
		if(strlen($newProfileEmail) > 255) {
			throw(new \RangeException("Email cannot contain more than 255 characters"));
		}
		$this->profileEmail = $newProfileEmail;

	}

	/**
	 * accessor method for profile email
	 * @return string
	 */

	public function getProfileHandle() {
		return ($this->profileHandle);
	}

	/**
	 * mutator method for profile handle
	 * @param int $newProfileHandle
	 * @throws \RangeException if $newProfileHandle is not positive
	 * @throws \TypeError if $newProfileHandle is not a string
	 **/

	public function setProfileHandle(string $newProfileHandle) {
		if(empty($newProfileHandle) === true) {
			throw(new \InvalidArgumentException("must create unique profile handle"));
		}
		if(strlen($newProfileHandle) > 21) {
			throw(new \RangeException("Profile handle cannot contain more than 21 characters"));
		}
		$this->profileHandle = $newProfileHandle;
	}

	/**
	 * accessor method for profile handle
	 * @return string
	 **/

	public function getProfileTimestamp() {
		return ($this->profileTimestamp);
	}

	/**
	 * mutator method for profile timestamp
	 * @param null $newProfileTimestamp
	 **/

	public function setProfileTimestamp($newProfileTimestamp = null) {
		if($newProfileTimestamp === null) {
			$this->profileTimestamp = new DateTime();
			return;
		}
		try {
			$newProfileTimestamp = self::validatetime($newProfileTimestamp);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw (new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $rangeException) {
			throw (new \RangeException($rangeException->getmessage(), 0, $rangeException));
		}
		$this->profileTimestamp = $newProfileTimestamp;
	}

	/** accessor method for profile timestamp
	 * @return $this profile timestamp
	 **/

	public function getProfileName() {
		return ($this->profileName);
	}

	/**
	 * mutator method for profile name
	 * @param int $newProfileName
	 * @throws \RangeException if $newProfileName is not positive
	 * @throws \TypeError if $newProfileName is not a string
	 **/

	public function setProfileName(string $newProfileName) {
		if(empty($newProfileName) === true) {
			throw(new \InvalidArgumentException("profile name must be a first and last name"));
		}
		if(strlen($newProfileName) > 30) {
			throw(new \RangeException("profile name cannot contain more than 30 characters"));
		}
		$this->profileName = $newProfileName;
	}

	/**
	 * accessor method for profile name
	 * @return string
	 **/

	public function getProfilePasswordHash() {
		return ($this->profilePasswordHash);
	}

	/**
	 * mutator method for profile password hash
	 * @param int $newProfilePasswordHash
	 * @throws \RangeException if $newProfilePasswordHash is not positive
	 * @throws \TypeError if $newProfilePasswordHash is not a string
	 **/

	public function setProfilePasswordHash(string $newProfilePasswordHash) {
		if(empty($newProfilePasswordHash) === true) {
			throw(new \InvalidArgumentException("profile password hash will be created in the string"));
		}
		if(strlen($newProfilePasswordHash) > 128) {
			throw(new \RangeException("profile password hash cannot contain more than 128 characters"));
		}
		$this->profilePasswordHash = $newProfilePasswordHash;
	}

	/**
	 * accessor method for profile password hash
	 * @return string
	 **/

	public function getProfileSalt() {
		return ($this->profileSalt);
	}

	/**
	 * mutator method for profile salt
	 * @param int $newProfileSalt
	 * @throws \RangeException if $newProfileSalt is not positive
	 * @throws \TypeError if $newProfileSalt is not a string
	 **/

	public function setProfileSalt(string $newProfileSalt) {
		if(empty($newProfileSalt) === true) {
			throw(new \InvalidArgumentException("profile salt created by hash"));
		}
		if(strlen($newProfileSalt) > 64) {
			throw(new \RangeException("profile salt cannot contain more than 64 characters"));
		}
		$this->profileSalt = $newProfileSalt;
	}

	/**
	 * accessor method for profile salt
	 * @return string
	 **/

	public function getProfileSummary() {
		return ($this->profileSummary);
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

	public function insert(\PDO $pdo) {
		if($this->profileId !== null) {
			throw(new \PDOException("not a new profile"));
		}
		$query = "INSERT INTO profile(profileImageId, profileActivation, profileEmail, profileHandle, profileName, profilePasswordHash, profileSalt, profileSummary) VALUES (:profileId, profileImageId, profileActivation, profileEmail, profileHandle, profileName, profilePasswordHash, profileSalt, profileSummary)";
		$statement = $pdo->prepare($query);
		$parameters = ["profileImageId" => $this->profileImageId, "profileActivation" => $this->profileActivation, "profileEmail" => $this->profileEmail, "profileHandle" => $this->profileHandle, "profileTimestamp" => $this->profileTimestamp, "profileName" => $this->profileName, "profilePasswordHash" => $this->profilePasswordHash, "profileSalt" => $this->profileSalt, "profileSummary" => $this->profileSummary];
		$statement->execute($parameters);
		//update null profileId
		$this->profileId = intval($pdo->lastInsertId());
	}

	/**
	 * delete this profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function delete(\PDO $pdo) {
		if($this->profileId === null) {
			throw(new \PDOException("cannot delete profile id that does not exist"));
		}

		$query = "DELETE FROM profile WHERE profileId = profileId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holder in the template
		$parameters = ["profileId" => $this->profileId];
		$statement->execute($parameters);
	}

	/**
	 * update profile in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function update(\PDO $pdo) {
		if($this->profileId === null) {
			throw(new \PDOException("cannot update profileId because it does not exist"));
		}

		//create query template
		$query = "UPDATE profile SET profileImageId = :profileImageId, profileActivation = :profileActivation, profileEmail = :profileEmail, profileHandle = :profileHandle, profileName = :profileName, profilePasswordHash = :profilePasswordHash, profileSalt = :profileSalt, profileSummary = :profileSummary";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId,
			"profileImageId" => $this->profileImageId,
			"profileActivation" => $this->profileActivation,
			"profileEmail" => $this->profileEmail,
			"profileHandle" => $this->profileHandle,
			"profileName" => $this->profileName,
			"profilePasswordHash" => $this->profilePasswordHash,
			"profileSalt" => $this->profileSalt,
			"profileSummary" => $this->profileSummary];
		$statement->execute($parameters);
	}

	/**
	 * delete function for mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occur
	 **/

	public static function getProfileByProfileId(\PDO $pdo, int $profileId) {
		if($profileId <= 0) {
			throw(new \RangeException("profileId is not greater than zero"));
		}
		//create query template
		$query = "SELECT profileId, profileImageId, profileActivation, profileEmail, profileHandle, profileTimestamp, profileName, profilePasswordHash, profileSalt, profileSummary FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		//bind variables to template
		$parameters = ["profileId" => $profileId];
		$statement->execute($parameters);
		try {
			$profileId = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profileId = new Profile($row["profileId"], $row["profileImageId"], $row ["profileActivation"], $row["profileEmail"], $row["profileHandle"], $row["profileTimestamp"], $row["profileName"], $row["profilePasswordHash"], $row["profileSalt"], $row["profileSummary"]);
			}
		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profileId);
	}

	/**
	 * get profile Id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of profile id found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/

	public static function getProfileByProfileImageId(\PDO $pdo, int $profileImageId) {
		if($profileImageId <= 0) {
			throw(new \RangeException("profile image id must be positive"));
		}

		$query = "SELECT profileId, profileImageId, profileActivation, profileEmail, profileHandle, profileTimestamp, profileName, profilePasswordHash, profileSalt, profileSummary FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		$parameters = ["profileImageId" => $profileImageId];
		$statement->execute($parameters);

		$profileImageId = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profileImageId = new Profile($row["profileId"], $row["profileImageId"], $row ["profileActivation"], $row["profileEmail"], $row["profileHandle"], $row["profileTimestamp"], $row["profileName"], $row["profilePasswordHash"], $row["profileSalt"], $row["profileSummary"]);
			}catch(Exception $exception){
				throw (new \PDOException(($exception->getProfile()), 0, $exception));
			}
		}
		return($profileImageId);

		/**
		 * get all profile image id
		 *
		 * @param \PDO $pdo PDO connection object
		 * @return \SplFixedArray SplFixedArray of profile image id found or null if not found
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError when variables are not the correct data type
		 **/
	}

	public static function getProfileByProfileActivation(\PDO $pdo, string $profileActivation) {
		$profileActivation = trim($profileActivation);
		$profileActivation = filter_var($profileActivation, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileActivation) === true) {
			throw(new \PDOException("profile activation is invalid"));
		}

		$query = "SELECT profileId, profileImageId, profileActivation, profileEmail, profileHandle, profileTimestamp, profileName, profilePasswordHash, profileSalt, profileSummary FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		$parameters = ["profileActivation" => $profileActivation];
		$statement->execute($parameters);

		$profileActivation = new \SplFixedArray(($statement->rowCount()));
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch() !== false)) ;
		try {
			$profileActivation = new Profile($row["profileId"], $row["profileImageId"], $row ["profileActivation"], $row["profileEmail"], $row["profileHandle"], $row["profileTimestamp"], $row["profileName"], $row["profilePasswordHash"], $row["profileSalt"], $row["profileSummary"]);
			$profileActivation[$profileActivation->key()] = $profileActivation;
			$profileActivation->next();
		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profileActivation);

		/**
		 * get the profile activation by profile
		 *
		 * @param \PDO $pdo PDO connection object
		 * @param int $profileActivation profile activation to search for
		 * @return Profile|null profile activation or null if not found
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError when variables are not the correct data type
		 **/
		}

	public static function getProfileByProfileEmail(\PDO $pdo, string $profileEmail){
			$profileEmail = trim($profileEmail);
			$profileEmail = filter_var($profileEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($profileEmail) === true){
				throw(new \PDOException("profile email is invalid"));
			}
			$query = "SELECT profileId, profileImageId, profileActivation, profileEmail, profileHandle, profileTimestamp, profileName, profilePasswordHash, profileSalt, profileSummary FROM profile WHERE profileId = :profileId";
			$statement = $pdo->prepare($query);

			$parameters = ["profileEmail" => $profileEmail];
			$statement->execute($parameters);

			$profileEmail = new \SplFixedArray(($statement->rowCount()));
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			while(($row = $statement->fetch() !== false));
				try {
					$profileEmail = new Profile($row["profileId"], $row["profileImageId"], $row ["profileActivation"], $row["profileEmail"], $row["profileHandle"], $row["profileTimestamp"], $row["profileName"], $row["profilePasswordHash"], $row["profileSalt"], $row["profileSummary"]);
					$profileEmail[$profileEmail->key()] = $profileEmail;
					$profileEmail->next();
				}catch(\Exception $exception){
					throw(new \PDOException($exception->getMessage(), 0, $exception));
				}
				return($profileEmail);

			/**
			 * get the profile email in class profile
			 *
			 * @param \PDO $pdp PDO connection object
			 * @param int $profileEmail profile email to search for
			 * @return Profile|null profile email or null if not found
			 * @throws \PDOException when mySQL related errors occur
			 * @throws \TypeError when variables are not the correct data type
			 **/
		}

	public static function getProfileByProfileHandle(\PDO $pdo, string $profileHandle){
		$profileHandle = trim($profileHandle);
		$profileHandle = filter_var($profileHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileHandle) === true){
			throw(new \PDOException("profile handle is invalid"));
		}
		$query = "SELECT profileId, profileImageId, profileActivation, profileEmail, profileHandle, profileTimestamp, profileName, profilePasswordHash, profileSalt, profileSummary FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		$parameters = ["profileHandle" => profileHandle];
		$statement->execute($parameters);

		$profileHandle = new \SplFixedArray(($statement->rowCount()));
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch() !== false));
			try {
				$profileHandle = new Profile ($row["profileId"], $row["profileImageId"], $row ["profileActivation"], $row["profileEmail"], $row["profileHandle"], $row["profileTimestamp"], $row["profileName"], $row["profilePasswordHash"], $row["profileSalt"], $row["profileSummary"]);
				$profileHandle[$profileHandle->key()] = $profileHandle;
				$profileHandle->next();
			}catch(\Exception $exception){
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			return($profileHandle);

			/**
			 * get the profile handle by profile
			 *
			 * @param \PDO $pdo PDO connection object
			 * @param int $profileHandle profile handle to search for
			 * @return Profile|null profile handle or null if not found
			 * @throws \PDOException when mySQL related errors occur
			 * @throws \TypeError when variables are not the correct data type
			 **/
		}

	public static function getProfileByProfileName(\PDO $pdo, string $profileName){
		$profileName = trim($profileName);
		$profileName = filter_var($profileName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileName) === true){
			throw(new \PDOException("profile name is invalid"));
			$query = "SELECT profileId, profileImageId, profileActivation, profileEmail, profileHandle, profileTimestamp, profileName, profilePasswordHash, profileSalt, profileSummary FROM profile WHERE profileId = :profileId";
			$statement = $pdo->prepare($query);

			$parameters = ["profileName" => $profileName];
			$statement->execute($parameters);

			$profileName = new \SplFixedArray(($statement->rowCount()));
			$statement->setFetch(PDO::FETCH_ASSOC);
			while(($row = $statement->fetch() !== false));
			try {
				$profileName = new Profile($row["profileId"], $row["profileImageId"], $row ["profileActivation"], $row["profileEmail"], $row["profileHandle"], $row["profileTimestamp"], $row["profileName"], $row["profilePasswordHash"], $row["profileSalt"], $row["profileSummary"]);
				$profileName[$profileName->key()] = $profileName;
				$profileName->next();
			}catch(\Exception $exception){
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			return($profileName);

			/**
			 * get profile name by profile
			 *
			 * @param \PDO $pdo PDO connection object
			 * @param int $profileName profile name to search for
			 * @return Profile|null profile name or null if not found
			 * @throws \PDOException when mySQL related errors occur
			 * @throws \TypeError when variables are not the correct data type
			 **/

		}
	}
}
?>