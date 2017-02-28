<?php
namespace Edu\Cnm\SproutSwap;
require_once("autoload.php");

/**
 * This class is what is stored when users create a new Profile
 *
 * @author A Zak Abad <abad.zacaria@gmail.com>
 * @version 1.0
 **/
class Profile implements \JsonSerializable {
	use ValidateDate;
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
	 * @var $profileTimestamp \DateTime current_timestamp
	 **/
	private $profileTimestamp;
	/**
	 * profileName will be end users real name
	 * @var $profileName string (30)
	 **/
	private $profileName;
	/**
	 * database will generate a hash value
	 * @var $profilePasswordHash string (128)
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

	/**
	 * Profile constructor.
	 * @param int|null $newProfileId
	 * @param int $newProfileImageId
	 * @param string $newProfileActivation
	 * @param string $newProfileEmail
	 * @param string $newProfileHandle
	 * @param \DateTime $newProfileTimestamp
	 * @param string $newProfileName
	 * @param string $newProfilePasswordHash
	 * @param string $newProfileSalt
	 * @param string $newProfileSummary
	 * @throws \Exception
	 * @throws \TypeError
	 */

	public function __construct(int $newProfileId = null, int $newProfileImageId = null, string $newProfileActivation = null, string $newProfileEmail, string $newProfileHandle, \DateTime $newProfileTimestamp = null, string $newProfileName, string $newProfilePasswordHash, string $newProfileSalt, string $newProfileSummary) {
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
	 * accessor method for profileId
	 *
	 * @return int|null value of profileId
	 **/
	public function getProfileId() {
		return ($this->profileId);
	}

	/**
	 * mutator method for profile id
	 *
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
	 * accessor method for Profile Image Id
	 *
	 * @return int $profileImageId
	 **/

	public function getProfileImageId() {
		return ($this->profileImageId);
	}

	/**
	 * mutator method for profile image id
	 *
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
	 * accessor method for Profile Activation
	 *
	 * @return string $profileActivation
	 **/

	public function getProfileActivation() {
		return ($this->profileActivation);
	}

	/**
	 * mutator method for profile activation
	 *
	 * @param string $newProfileActivation
	 * @throws \InvalidArgumentException if $newProfileActivation is insecure
	 * @throws \RangeException if $newProfileActivation is > 16 characters
	 * @throws \TypeError if $newProfileActivation is not a string
	 **/

	public function setProfileActivation(string $newProfileActivation = null) {
		if($newProfileActivation === null){
			$this->profileActivation = null;
			return;
		}
		$newProfileActivation = trim($newProfileActivation);
		$newProfileActivation = filter_var($newProfileActivation, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileActivation) === true) {
			throw(new \InvalidArgumentException("profile activation is empty or insecure"));
		}
		if(strlen($newProfileActivation) > 64) {
			throw(new \RangeException("profile activation cannot be more than 64 characters"));
		}
		$this->profileActivation = $newProfileActivation;
	}

	/**
	 * accessor method for profile email
	 *
	 * @return string $profileEmail email for profile
	 **/

	public function getProfileEmail() {
		return ($this->profileEmail);
	}

	/**
	 * mutator method for profile email
	 *
	 * @param string $newProfileEmail
	 * @throws \RangeException if $newProfileEmail is not positive
	 * @throws \TypeError if $newProfileEmail is not a string
	 **/

	public function setProfileEmail(string $newProfileEmail) {
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_EMAIL);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("Must have email address"));
		}
		if(strlen($newProfileEmail) > 255) {
			throw(new \RangeException("Email cannot contain more than 255 characters"));
		}
		$this->profileEmail = $newProfileEmail;

	}

	/**
	 * accessor method for profile handle
	 *
	 * @return string $profileHandle
	 */

	public function getProfileHandle() {
		return ($this->profileHandle);
	}

	/**
	 * mutator method for profile handle
	 *
	 * @param string $newProfileHandle
	 * @throws \RangeException if $newProfileHandle greater than 21
	 * @throws \TypeError if $newProfileHandle is not a string
	 **/

	public function setProfileHandle(string $newProfileHandle) {
		$newProfileHandle = trim($newProfileHandle);
		$newProfileHandle = filter_var($newProfileHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileHandle) === true) {
			throw(new \InvalidArgumentException("must create unique profile handle"));
		}
		if(strlen($newProfileHandle) > 21) {
			throw(new \RangeException("Profile handle cannot contain more than 21 characters"));
		}
		$this->profileHandle = $newProfileHandle;
	}

	/**
	 * accessor method for profile timestamp
	 *
	 * @return \DateTime|$profileTimestamp
	 **/

	public function getProfileTimestamp() {
		return ($this->profileTimestamp);
	}

	/**
	 * mutator method for profile timestamp
	 *
	 * @param null $newProfileTimestamp
	 * @throws \InvalidArgumentException if its not a valid date
	 * @throws \RangeException if the date is before 1970
	 **/

	public function setProfileTimestamp($newProfileTimestamp = null) {
		if($newProfileTimestamp === null) {
			$this->profileTimestamp = new \DateTime();
			return;
		}
		try {
			$newProfileTimestamp = self::validateDateTime($newProfileTimestamp);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw (new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $rangeException) {
			throw (new \RangeException($rangeException->getmessage(), 0, $rangeException));
		}
		$this->profileTimestamp = $newProfileTimestamp;
	}

	/** accessor method for profile name
	 *
	 * @return string $profileName
	 **/

	public function getProfileName() {
		return ($this->profileName);
	}

	/**
	 * mutator method for profile name
	 *
	 * @param string $newProfileName
	 * @throws \RangeException if $newProfileName greater than 30
	 * @throws \TypeError if $newProfileName is not a string
	 **/

	public function setProfileName(string $newProfileName) {
		$newProfileName = trim($newProfileName);
		$newProfileName = filter_var($newProfileName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileName) === true) {
			throw(new \InvalidArgumentException("profile name must be a first and last name"));
	}
		if(strlen($newProfileName) > 30) {
			throw(new \RangeException("profile name cannot contain more than 30 characters"));
		}
		$this->profileName = $newProfileName;
	}

	/**
	 * accessor method for profile password hash
	 *
	 * @return string $profilePasswordHash
	 **/

	public function getProfilePasswordHash() {
		return ($this->profilePasswordHash);
	}

	/**
	 * mutator method for profile password hash
	 *
	 * @param string $newProfilePasswordHash
	 * @throws \InvalidArgumentException if ProfilePasswordHash is empty
	 * @throws \RangeException if $newProfilePasswordHash greater than 128
	 * @throws  \TypeError if $newProfilePasswordHash is not a string
	 **/

	public function setProfilePasswordHash(string $newProfilePasswordHash) {
		$newProfilePasswordHash = trim($newProfilePasswordHash);
		$newProfilePasswordHash = filter_var($newProfilePasswordHash, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfilePasswordHash) === true) {
			throw(new \InvalidArgumentException("profile password hash empty or insecure"));
		}

		if(!ctype_xdigit($newProfilePasswordHash)) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
		}
		if(strlen($newProfilePasswordHash) !==128 ) {
			throw(new \RangeException("profile password hash must be 128 characters"));
		}
		$this->profilePasswordHash = $newProfilePasswordHash;
	}

	/**
	 * accessor method for profile password salt
	 *
	 * @return string $profileSalt
	 **/

	public function getProfileSalt() {
		return ($this->profileSalt);
	}

	/**
	 * mutator method for profile salt
	 *
	 * @param string $newProfileSalt
	 * @throws \RangeException if $newProfileSalt greater than 64
	 * @throws \TypeError if $newProfileSalt is not a string
	 **/

	public function setProfileSalt(string $newProfileSalt) {
		$newProfileSalt = trim($newProfileSalt);
		$newProfileSalt = filter_var($newProfileSalt, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileSalt) === true) {
			throw(new \InvalidArgumentException("profile salt created by hash"));
		}
		if(!ctype_xdigit($newProfileSalt)) {
			throw(new \InvalidArgumentException("profile salt is empty or insecure"));
		}
		if(strlen($newProfileSalt) !== 64) {
			throw(new \RangeException("profile salt must be 64 characters"));
		}
		$this->profileSalt = $newProfileSalt;
	}

	/**
	 * accessor method for profile summary
	 *
	 * @return string $profileSummary
	 **/

	public function getProfileSummary() {
		return ($this->profileSummary);
	}

	/**
	 * mutator method for profile summary
	 *
	 * @param string $newProfileSummary
	 * @throws \RangeException if $newProfileSummary greater than 255
	 * @throws \TypeError if $newProfileSummary is not a string
	 **/

	public function setProfileSummary(string $newProfileSummary) {
		$newProfileSummary = trim($newProfileSummary);
		$newProfileSummary = filter_var($newProfileSummary, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileSummary) === true) {
			throw(new \InvalidArgumentException(("profile summary created by user")));
		}
		if(strlen($newProfileSummary) > 255) {
			throw(new \RangeException("profile summary cannot contain more than 255 characters"));
		}
		$this->profileSummary = $newProfileSummary;

	}

	/**
	 * insert method for profile
	 *
	 * @param \PDO $pdo
	 * @throws \PDOException if not a new profile
	 **/

	public function insert(\PDO $pdo) {
		if($this->profileId !== null) {
			throw(new \PDOException("not a new profile"));
		}
		$query = "INSERT INTO profile(profileImageId, profileActivation, profileEmail, profileHandle, profileTimestamp, profileName, profilePasswordHash, profileSalt, profileSummary) VALUES (:profileImageId, :profileActivation, :profileEmail, :profileHandle, :profileTimestamp, :profileName, :profilePasswordHash, :profileSalt, :profileSummary)";
		$statement = $pdo->prepare($query);
		$formattedDate = $this->profileTimestamp->format("Y-m-d H:i:s");
		$parameters = ["profileImageId" => $this->profileImageId, "profileActivation" => $this->profileActivation, "profileEmail" => $this->profileEmail, "profileHandle" => $this->profileHandle, "profileTimestamp" => $formattedDate, "profileName" => $this->profileName, "profilePasswordHash" => $this->profilePasswordHash, "profileSalt" => $this->profileSalt, "profileSummary" => $this->profileSummary];
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

		$query = "DELETE FROM profile WHERE profileId = :profileId";
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
		$query = "UPDATE profile SET  profileImageId = :profileImageId, profileActivation = :profileActivation, profileEmail = :profileEmail, profileHandle = :profileHandle,profileTimestamp = :profileTimestamp, profileName = :profileName, profilePasswordHash = :profilePasswordHash, profileSalt = :profileSalt, profileSummary = :profileSummary WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		$formattedDate = $this->profileTimestamp->format("Y-m-d H:i:s");

		//bind the member variables to the place holders in the template
		$parameters = [
			"profileId" => $this->profileId,
			"profileImageId" => $this->profileImageId,
			"profileActivation" => $this->profileActivation,
			"profileEmail" => $this->profileEmail,
			"profileHandle" => $this->profileHandle,
			"profileTimestamp" => $formattedDate,
			"profileName" => $this->profileName,
			"profilePasswordHash" => $this->profilePasswordHash,
			"profileSalt" => $this->profileSalt,
			"profileSummary" => $this->profileSummary];
		$statement->execute($parameters);
	}

	/**
	 * gets profile by the profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int profile id
	 * @throws \RangeException if profile id is 0
	 * @throws \PDOException when mySQL errors occur
	 * @return $profile with the id
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
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileImageId"], $row ["profileActivation"], $row["profileEmail"], $row["profileHandle"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["profileTimestamp"]), $row["profileName"], $row["profilePasswordHash"], $row["profileSalt"], $row["profileSummary"]);
			}
		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}

	/**
	 * get profile with the certain image id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/

	public static function getProfileByProfileImageId(\PDO $pdo, $profileImageId) {
		if($profileImageId <= 0) {
			throw(new \RangeException("profile image id must be positive"));
		}

		$query = "SELECT profileId, profileImageId, profileActivation, profileEmail, profileHandle, profileTimestamp, profileName, profilePasswordHash, profileSalt, profileSummary FROM profile WHERE profileImageId = :profileImageId";
		$statement = $pdo->prepare($query);

		$parameters = ["profileImageId" => $profileImageId];
		$statement->execute($parameters);

		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileImageId"], $row ["profileActivation"], $row["profileEmail"], $row["profileHandle"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["profileTimestamp"]), $row["profileName"], $row["profilePasswordHash"], $row["profileSalt"], $row["profileSummary"]);
			}
		} catch(\Exception $exception) {
			throw (new \PDOException(($exception->getMessage()), 0, $exception));
		}
		return ($profile);
	}
		/**
		 * get a profile By Activation code
		 *
		 * @param \PDO $pdo PDO connection object
		 * @param string $profileActivation
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError when variables are not the correct data type
		 * @return $profile that matches code
		 **/

	public static function getProfileByProfileActivation(\PDO $pdo, string $profileActivation) {
		$profileActivation = trim($profileActivation);
		$profileActivation = filter_var($profileActivation, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileActivation) === true) {
			throw(new \PDOException("profile activation is invalid"));
		}

		$query = "SELECT profileId, profileImageId, profileActivation, profileEmail, profileHandle, profileTimestamp, profileName, profilePasswordHash, profileSalt, profileSummary FROM profile WHERE profileActivation = :profileActivation";
		$statement = $pdo->prepare($query);

		$parameters = ["profileActivation" => $profileActivation];
		$statement->execute($parameters);

		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileImageId"], $row ["profileActivation"], $row["profileEmail"], $row["profileHandle"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["profileTimestamp"]), $row["profileName"], $row["profilePasswordHash"], $row["profileSalt"], $row["profileSummary"]);
			}
		} catch(\Exception $exception) {
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}
		/**
		 * get profiles by the profile email
		 *
		 * @param \PDO $pdo PDO connection object
		 * @param string $profileEmail profile email to search for
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError when variables are not the correct data type
		 **/


	public static function getProfileByProfileEmail(\PDO $pdo, string $profileEmail) {
		$profileEmail = trim($profileEmail);
		$profileEmail = filter_var($profileEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileEmail) === true) {
			throw(new \PDOException("profile email is invalid"));
		}
		$query = "SELECT profileId, profileImageId, profileActivation, profileEmail, profileHandle, profileTimestamp, profileName, profilePasswordHash, profileSalt, profileSummary FROM profile WHERE profileEmail = :profileEmail";
		$statement = $pdo->prepare($query);

		$parameters = ["profileEmail" => $profileEmail];
		$statement->execute($parameters);

		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileImageId"], $row ["profileActivation"], $row["profileEmail"], $row["profileHandle"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["profileTimestamp"]), $row["profileName"], $row["profilePasswordHash"], $row["profileSalt"], $row["profileSummary"]);
			}
		} catch(\Exception $exception) {
			throw (new \PDOException(($exception->getMessage()), 0, $exception));
		}
		return ($profile);
	}
		/**
		 * get the profiles by profile handle
		 *
		 * @param \PDO $pdo PDO connection object
		 * @param string $profileHandle profile email to search for
		 * @return \SplFixedArray of profiles or null if not found
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError when variables are not the correct data type
		 **/

	public static function getProfileByProfileHandle(\PDO $pdo, string $profileHandle) {
		$profileHandle = trim($profileHandle);
		$profileHandle = filter_var($profileHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileHandle) === true) {
			throw(new \PDOException("profile handle is invalid"));
		}
		$query = "SELECT profileId, profileImageId, profileActivation, profileEmail, profileHandle, profileTimestamp, profileName, profilePasswordHash, profileSalt, profileSummary FROM profile WHERE profileHandle = :profileHandle";
		$statement = $pdo->prepare($query);

		$parameters = ["profileHandle" => $profileHandle];
		$statement->execute($parameters);

		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileImageId"], $row ["profileActivation"], $row["profileEmail"], $row["profileHandle"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["profileTimestamp"]), $row["profileName"], $row["profilePasswordHash"], $row["profileSalt"], $row["profileSummary"]);
			}
		} catch(\Exception $exception) {
			throw (new \PDOException(($exception->getMessage()), 0, $exception));
		}
		return ($profile);
	}

		/**
		 * get the profile by profile name
		 *
		 * @param \PDO $pdo PDO connection object
		 * @param string $profileName profile name to search for
		 * @return \SplFixedArray of profiles or null if not found
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError when variables are not the correct data type
		 **/

	public static function getProfileByProfileName(\PDO $pdo, string $profileName) {
		$profileName = trim($profileName);
		$profileName = filter_var($profileName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileName) === true) {
			throw(new \PDOException("profile name is invalid"));
		}
		$query = "SELECT profileId, profileImageId, profileActivation, profileEmail, profileHandle, profileTimestamp, profileName, profilePasswordHash, profileSalt, profileSummary FROM profile WHERE profileName LIKE :profileName";
		$statement = $pdo->prepare($query);

		$profileName = "%$profileName%";
		$parameters = ["profileName" => $profileName];
		$statement->execute($parameters);

		$profiles = new \SplFixedArray(($statement->rowCount()));
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileImageId"], $row ["profileActivation"], $row["profileEmail"], $row["profileHandle"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["profileTimestamp"]), $row["profileName"], $row["profilePasswordHash"], $row["profileSalt"], $row["profileSummary"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);

	}

	/**
	 * get profiles by profile summary
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileSummary profile summary to search for
	 * @return \SplFixedArray of profiles or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/

	public static function getProfileByProfileSummary(\PDO $pdo, string $profileSummary) {
		$profileSummary = trim($profileSummary);
		$profileSummary = filter_var($profileSummary, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileSummary) === true) {
			throw(new \PDOException("profile summary is invalid"));
		}
		$query = "SELECT profileId, profileImageId, profileActivation, profileEmail, profileHandle, profileTimestamp, profileName, profilePasswordHash, profileSalt, profileSummary FROM profile WHERE profileSummary LIKE :profileSummary";
		$statement = $pdo->prepare($query);

		$profileSummary = "%$profileSummary%";
		$parameters = ["profileSummary" => $profileSummary];
		$statement->execute($parameters);

		$profiles = new \SplFixedArray(($statement->rowCount()));
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileImageId"], $row ["profileActivation"], $row["profileEmail"], $row["profileHandle"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["profileTimestamp"]), $row["profileName"], $row["profilePasswordHash"], $row["profileSalt"], $row["profileSummary"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);

	}

	/**
	 * get profiles
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray of profiles or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/

	public static function getAllProfiles(\PDO $pdo) {
		//create query template
		$query = "SELECT profileId, profileImageId, profileActivation, profileEmail, profileHandle, profileTimestamp, profileName, profilePasswordHash, profileSalt, profileSummary FROM profile ";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileImageId"], $row ["profileActivation"], $row["profileEmail"], $row["profileHandle"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["profileTimestamp"]), $row["profileName"], $row["profilePasswordHash"], $row["profileSalt"], $row["profileSummary"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				throw (new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);
	}

	/**
	 * formats variables for JSON serialization
	 * @return array with state variable to serialize
	 **/

	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["profileTimestamp"] = $this->profileTimestamp->getTimestamp() * 1000;
		return ($fields);
	}
}