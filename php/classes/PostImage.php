<?PHP
namespace Edu\Cnm\SproutSwap;
require_once ("autoload.php");

/**
 * Class PostImage weak entity
 * @see Post
 * @see Image
 * @package Edu\Cnm\SproutSwap
 */
class PostImage implements \JsonSerializable{
	/**
	 * foreign key
	 * @var int $postImageImageId
	 */
	private $postImageImageId;
	/**
	 * foreign key
	 * @var int $postImagePostId
	 */
	private $postImagePostId;
	/**
	 * PostImage constructor.
	 * @param int $newPostImageImageId
	 * @param int $newPostImagePostId
	 * @throws \Exception if some error occurs
	 * @throws \TypeError if data is in incorrect formats
	 * @throws \InvalidArgumentException if invalid data
	 * @throws \RangeException if data outside of bounds
	 */
	public function __construct(int $newPostImageImageId, int $newPostImagePostId) {
		try{
			$this->setPostImageImageId($newPostImageImageId);
			$this->setPostImagePostId($newPostImagePostId);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $rangeException) {
			throw (new \RangeException($rangeException->getMessage(), 0, $rangeException));
		} catch(\TypeError $typeError) {
			throw (new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			throw (new \Exception($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for PostImageImageId
	 * @return int
	 */
	public function getPostImageImageId(){
		return $this->postImageImageId;
	}
	/**
	 * mutator method for postImageImageId
	 * @param int $newPostImageImageId
	 * @throws \RangeException if postImageImageId is less than or equal to zero
	 */
	public function setPostImageImageId(int $newPostImageImageId) {
		if($this->postImageImageId >= 0){
			throw(new \RangeException("postImageImageId must be greater than zero"));
		}
		$this->postImageImageId = $newPostImageImageId;
	}

	/**
	 * accessor method for postImagePostId
	 * @return int
	 */
	public function getPostImagePostId(){
		return $this->postImagePostId;
	}
	/**
	 * @param int $newPostImagePostId
	 * @throws \RangeException if postImagePostId is less than or equal to zero
	 */
	public function setPostImagePostId(int $newPostImagePostId){
		if($this->postImagePostId >= 0){
			throw(new \RangeException("postImageImageId must be greater than zero"));
		}
		$this->postImagePostId = $newPostImagePostId;
	}
	/**
	 * insert method
	 * @param \PDO $pdo PHP data connection object
	 */
	public function insert(\PDO $pdo){
		//create query template
		$query = "INSERT INTO postImage(postImageImageId, postImagePostId) VALUES(:postImageImageId, :postImagePostId)";
		$statement = $pdo->prepare($query);
		//bind variables and execute
		$parameters = ["postImageImageId" => $this->postImageImageId, "postImagePostId" => $this->postImagePostId];
		$statement->execute($parameters);
	}
	/**
	 * Delete function for postImage table
	 * @param \PDO $pdo PHP data connection object
	 */
	public function delete(\PDO $pdo){
		//create query template
		$query = "DELETE FROM postImage WHERE postImageImageId = :postImageImageId AND postImagePostId = :postImagePostId";
		$statement = $pdo->prepare($query);
		//bind variables
		$parameters = ["postImageImageId" => $this->postImageImageId, "postImagePostId" => $this->postImagePostId];
		$statement->execute($parameters);
	}
	/**
	 * @param \PDO $pdo
	 * @param int $postImagePostId
	 */
	public static function getPostImageByPostImagePostId(\PDO $pdo, int $postImagePostId){
		if($postImagePostId <= 0){
			throw(new \RangeException("postImagePostId must be greater than 0"));
		}
		//create query template
		$query = "SELECT postImageImageId, postImagePostId FROM postImage WHERE postImagePostId = :postImagePostId";
		$statement = $pdo->prepare($query);
		//bind variables and execute
		$parameters = ["postImagePostId" => $postImagePostId];
		$statement->execute($parameters);
	}
	/**
	 * @param \PDO $pdo
	 * @param int $postImageImageId
	 * @param int $postImagePostId
	 */
	public static function getPostImageByPostImageImageIdAndPostImagePostId(\PDO $pdo, int $postImageImageId, int $postImagePostId){
		if($postImageImageId <= 0){
			throw(new \RangeException("postImageImageId must be greater than 0"));
		} else if($postImagePostId <= 0){
			throw(new \RangeException("postImagePostId must be greater than 0"));
		}
		//create query template
		$query = "SELECT postImageImageId, postImagePostId FROM postImage WHERE postImageImageId = :postImageImageId AND postImagePostId = :postImagePostId";
		$statement = $pdo->prepare($query);
		//bind variables and execute
		$parameters = ["postImageImageId" => $postImageImageId, "postImagePostId" => $postImagePostId];
		$statement->execute($parameters);
	}
	/**
	 * JSON Serializable method
	 * @return array of data to be serialized
	 */
	public function jsonSerialize(){
		$fields = get_object_vars($this);
		return($fields);
	}
}