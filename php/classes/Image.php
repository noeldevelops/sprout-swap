<?php
namespace Edu\Cnm\SproutSwap;
require_once("autoload.php");
/**
 * This class is for images that users upload
 *
 * @author SproutSwap
 * @author A Noel Cothren <noelcothren@gmail.com>
 * @version 1.0
 **/
class Image implements \jsonSerializable {
	/**
	 * id for the image, this is the primary key
	 * @var int $imageId
	 */
	private $imageId;
	/**
	 * id for the image on Cloudinary API
	 * @var string $imageCloudinaryId
	 */
	private $imageCloudinaryId;

	/**
	 * constructor for this Image
	 * @param int|null $newImageId id of this image
	 * @param string $newImageCloudinaryId id of the image on Cloudinary API
	 * @throws \TypeError if data violates type hints
	 * @throws \Exception if some other exception occurs
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are negative or too long
	 */
	public function __construct(int $newImageId = null, string $newImageCloudinaryId) {
		try {
			$this->setImageId($newImageId);
			$this->setImageCloudinaryId($newImageCloudinaryId);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for image id
	 * @returns int|null value of image id
	 */
	public function getImageId() {
		return($this->imageId);
	}
	/**
	 * mutator method for image id
	 * @param int|null $newImageId new value of image id
	 * @throws \RangeException if $newImageId is not positive
	 * @throws \TypeError if $newImageId is not an integer
	 */
	public function setImageId(int $newImageId = null) {
		if($newImageId === null) {
			$this->imageId = null;
			return;
		}
		if($newImageId <= 0) {
			throw(new \RangeException("Image id is not positive"));
		}
		$this->imageId = $newImageId;
	}
	/**
	 * accessor method for image cloudinary id
	 * @returns string value of image cloudinary id
	 */
	public function getImageCloudinaryId(){
		return($this->imageCloudinaryId);
	}
	/**
	 * mutuator method for image cloudinary id
	 * @param string $newImageCloudinaryId new value of cloudinary id
	 * @throws \InvalidArgumentException if cloudinary id is empty or insecure
	 * @throws \TypeError if $newImageCloudinaryId is not an string
	 */
	public function setImageCloudinaryId(string $newImageCloudinaryId) {
		$newImageCloudinaryId = filter_var($newImageCloudinaryId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newImageCloudinaryId) === true) {
			throw(new \InvalidArgumentException("ID is empty or insecure"));
		}
		$this->imageCloudinaryId = $newImageCloudinaryId;
	}
	/**
	 * insert an Image
	 * @param \PDO $pdo
	 * @throws \TypeError
	 */
	public function insert (\PDO $pdo){
		//ensure image id is null
		if($this->imageId !==  null){
			throw (new \PDOException("Image already exists in database"));
		} elseif(is_string($this->imageCloudinaryId) === false) {
			throw (new \TypeError("Cloudinary Id is not a string"));
		}
		// create query template
		$query = "INSERT INTO image(imageCloudinaryId) VALUES (:imageCloudinaryId)";
		$statement = $pdo->prepare($query);
		//bind variables
		$parameters = ["imageCloudinaryId" => $this->imageCloudinaryId];
		$statement->execute($parameters);
		//update null messageId
		$this->imageId = intval($pdo->lastInsertId());
	}
	/**
	 * delete an Image
	 * @param \PDO $pdo
	 * @throws \PDOException when mySQL errors occur
	 */
	public function delete (\PDO $pdo){
		//ensure image id is null
		if($this->imageId ===  null){
			throw (new \PDOException("Can't delete an image that doesn't exist"));
		}
		// create query template
		$query = "DELETE FROM image WHERE imageId = $this->imageId";
		$statement = $pdo->prepare($query);
		//bind variables
		$parameters = ["imageId" => $this->imageId];
		$statement->execute($parameters);
	}
	/** gets an image by the imageId
	 * @param \PDO $pdo PDO Connection Object
	 * @param int $imageId image id to search for
	 * @return Image|null Image found or doesn't exist
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError when variables are not correct type
	 **/
	 public static function getImageByImageId(\PDO $pdo, int $imageId) {
		//throw an exception if imageId is empty
		if($imageId <= 0) {
			throw(new \PDOException("Image ID is not positive"));
		}
		$query = "SELECT imageId, imageCloudinaryId FROM image WHERE imageId = :imageId";
		$statement = $pdo->prepare($query);
		$parameters = ["imageId" => $imageId];
		$statement->execute($parameters);
		 try {
			 $image = null;
			 $statement->setFetchMode(\PDO::FETCH_ASSOC);
			 $row = $statement->fetch();
			 if($row !== false) {
				 $image = new Image($row["imageId"], $row["imageCloudinaryId"]);
			 }
		 } catch(\Exception $exception) {
			 // if the row couldn't be converted, rethrow it
			 throw(new \PDOException($exception->getMessage(), 0, $exception));
		 }
		 return($image);
	}
	/** gets an image by the imageCloudinaryId
	 * @param \PDO $pdo PDO Connection Object
	 * @param string $imageCloudinaryId image id from Cloudinary API to search for
	 * @return Image|null Image found or doesn't exist
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError when variables are not correct type
	 **/
	public static function getImageByImageCloudinaryId(\PDO $pdo, string $imageCloudinaryId) {
		//throw an exception if imageId is empty
		if(is_string($imageCloudinaryId) !== true) {
			throw(new \TypeError("Image Cloudinary ID is not a string"));
		} elseif(strlen($imageCloudinaryId) > 32) {
			throw(new \RangeException("ID is too long"));
		}
			$query = "SELECT imageId, imageCloudinaryId FROM image WHERE imageCloudinaryId = :imageCloudinaryId";
			$statement = $pdo->prepare($query);

			$parameters = ["imageCloudinaryId" => $imageCloudinaryId];
			$statement->execute($parameters);
			try {
				$image = null;
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $statement->fetch();
				if($row !== false) {
					$image = new Image($row["imageId"], $row["imageCloudinaryId"]);
				}
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			return ($image);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return($fields);
	}
}