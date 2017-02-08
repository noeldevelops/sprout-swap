<?php
namespace Edu\Cnm\SproutSwap;
require_once("autoload.php");
/**
 * This class is what is stored when users create a new Post
 *
 * @author A Noel Cothren <noelcothren@gmail.com>
 * @version 1.0
 **/

class Post implements \jsonSerializable {
	use ValidateDate;
	/**
	 * id for this Post; this is the primary key
	 * @var int $postId
	 **/
	private $postId;
	/**
	 * Mode of the Post - buy, sell, trade
	 * this is a foreign key
	 * @var int $postModeId
	 */
	private $postModeId;
	/**
	 * Id of the profile which created this post, foreign key
	 * @var int $postProfileId
	 */
	private $postProfileId;
	/**
	 * auto-generated browser info for the user who created post
	 * @var string $postBrowser
	 */
	private $postBrowser;
	/**
	 * actual content of the post
	 * @var string $postContent
	 */
	private $postContent;
	/**
	 *IP Address from the User who is creating post
	 *@var string $postIpAddress
	 **/
	private $postIpAddress;
	/**
	 * geolocation of user who creates post
	 * @use Point class
	 * @var Point $postLocation
	 */
	private $postLocation;
	/**
	 * this is the specific item(s) user is offering
	 * @var string $postOffer
	 */
	private $postOffer;
	/**
	 * what is the user requesting in return for offer
	 * @var string $postRequest
	 */
	private $postRequest;
	/**
	 * Timestamp when post is created
	 * @var int $postTimestamp
	 */
	private $postTimestamp;
	/**
	 * constructor for this Post
	 *
	 * @param int|null $newPostId id of this post or null if new post
	 * @param int $newPostModeId mode id of the post according to user choice
	 * @param int $newPostProfileId id of the profile that created this post
	 * @param string $newPostBrowser auto-generated browser info for the user who created post
	 * @param string $newPostContent actual content of the post
	 * @param string $newPostIpAddress IP Address of user who created post
	 * @param Point $newPostLocation geolocation of user who created post
	 * @param string $newPostOffer string containing user's offer
	 * @param string $newPostRequest string containing user's request
	 * @param \DateTime $newPostTimestamp contains date and time post was created
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	 public function __construct(int $newPostId = null, int $newPostModeId, int $newPostProfileId, string $newPostBrowser, string $newPostContent, string $newPostIpAddress, Point $newPostLocation, string $newPostOffer, string $newPostRequest, int $newPostTimestamp ) {
		 try {
			 $this->setPostId($newPostId);
			 $this->setPostModeId($newPostModeId);
			 $this->setPostProfileId($newPostProfileId);
			 $this->setPostBrowser($newPostBrowser);
			 $this->setPostContent($newPostContent);
			 $this->setPostIpAddress($newPostIpAddress);
			 $this->setPostLocation($newPostLocation);
			 $this->setPostOffer($newPostOffer);
			 $this->setPostRequest($newPostRequest);
			 $this->setPostTimestamp($newPostTimestamp);
		 } catch(\InvalidArgumentException $invalidArgument) {
			 // rethrow the exception to the caller
			 throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		 } catch(\RangeException $range) {
			 // rethrow the exception to the caller
			 throw(new \RangeException($range->getMessage(), 0, $range));
		 } catch(\TypeError $typeError) {
			 // rethrow the exception to the caller
			 throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		 } catch(\Exception $exception) {
			 // rethrow the exception to the caller
			 throw(new \Exception($exception->getMessage(), 0, $exception));
		 }
	 }
	 /**
	  * accessor method for this Post id
	  * @return int|null value of post id
	  **/
	 public function getPostId() {
	 	return($this->postId);
	 }
	 /**
	  * mutator method for post ID
	  * @param int|null $newPostId new value of postID
	  * @throws \RangeException if $newPostId is not positive
	  * @throws \TypeError if $newPostId is not an integer
	  **/
	 public function setPostId(int $newPostId = null) {
	 	if($newPostId === null) {
			$this->postId = null;
			return;
		}
		if($newPostId <= 0) {
	 		throw(new \RangeException("Post ID cannot be negative"));
		}
		$this->postId = $newPostId;
	 }
	 /**
	  * accessor method for Post Mode Id
	  * @return int
	  */
	 public function getPostModeId() {
	 	return($this->postModeId);
	 }
	 /**
	  * mutator method for Post Mode Id
	  *
	  * @param int $newPostModeId
	  * @throws \RangeException if $newPostModeId is not positive
	  * @throws \RangeException if $newPostModeId is > 3
	  * @throws \TypeError if $newPostModeId is not an integer
	  **/
	 public function setPostModeId(int $newPostModeId) {
	 	if($newPostModeId <= 0) {
	 		throw(new \RangeException("Mode Id must be positive"));
		}
		if($newPostModeId > 3) {
	 		throw(new \RangeException("Mode Id is out of range"));
		}
		$this->postModeId = $newPostModeId;
	 }
	 /**
	  * accessor method for post profile id
	  * @return int
	  */
	 public function getPostProfileId() {
	 	return($this->postProfileId);
	 }
	 /**
	  * mutator method for post profile id
	  * @param int $newPostProfileId
	  * @throws \RangeException if $newPostProfileId is not positive
	  * @throws \TypeError if $newPostProfileId is not an integer
	  */
	 public function setPostProfileId(int $newPostProfileId) {
		 if($newPostProfileId <= 0) {
			 throw(new \RangeException("Keep it positive!"));
		 }
		 $this->postProfileId = $newPostProfileId;
	 }
	 /**
	  * accessor method for post browser
	  * @return string
	  */
	 public function getPostBrowser() {
	 	return($this->postBrowser);
	 }
	 /**
	  * mutator method for post browser
	  * @param string $newPostBrowser new value of postBrowser
	  * @throws \InvalidArgumentException if $newPostBrowser is insecure
	  * @throws \RangeException if $newPostBrowser is > 255 characters
	  * @throws \TypeError if $newPostBrowser is not a string
	  */
	 public function setPostBrowser(string $newPostBrowser) {
	 	$newPostBrowser = filter_var($newPostBrowser, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	 	if(strlen($newPostBrowser) > 255) {
	 		throw(new \RangeException("Browser content is too large"));
		}
	 	$this->postBrowser = $newPostBrowser;
	 }
	 /**
	  *accessor method for post content
	  * @return string value of post content
	  **/
	 public function getPostContent() {
	 		return($this->postContent);
	 }
	 /**
	  * mutator method for post content
	  * @param string $newPostContent new value of post content
	  * @throws \InvalidArgumentException if $newPostContent is insecure
	  * @throws \RangeException if $newPostContent is > 255 characters
	  * @throws \TypeError if $newPostContent is not a string
	  **/
	 public function setPostContent(string $newPostContent) {
	 	$newPostContent = trim($newPostContent);
	 	$newPostContent = filter_var($newPostContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	 	if(empty($newPostContent) === true) {
			throw(new \InvalidArgumentException("Your post is empty or insecure."));
		} if(strlen($newPostContent) > 255) {
			throw(new \RangeException("Your post content is far too wordy."));
		}
		$this->postContent = $newPostContent;
	 }
	 /**
	  * accessor method for postIpAddress
	  * @returns string value of users IP address
	  */
	 public function getPostIpAddress () {
	 	return($this->postIpAddress);
	 }
	 /**
	  * mutator method for Post IP Address
	  * @param string $newPostIpAddress value of users IP Address
	  * @throws \InvalidArgumentException if IP address is not a valid ip address
	  */
	 public function setPostIpAddress(string $newPostIpAddress) {
	 	$newPostIpAddress = filter_var($newPostIpAddress, FILTER_VALIDATE_IP);
	 	$this->postIpAddress = $newPostIpAddress;
	 }
	 /**
	  * accessor method for post location
	  * @returns Point value of post location
	  */
	 public function getPostLocation() {
	 	return($this->postLocation);
	 }
	 /**
	  * mutator method for post location
	  * @param Point $newPostLocation new value of post location
	  *
	  */
	 public function setPostLocation(Point $newPostLocation) {
	 	$this->postLocation = $newPostLocation;
	 }
	 /**
	  * accessor method for post offer
	  * @returns string value of post offer
	  */
	 public function getPostOffer() {
	 	return($this->postOffer);
	 }
	 /**
	  * mutator method for post offer
	  * @param string $newPostOffer value of post offer
	  * @throws \InvalidArgumentException if $newPostOffer is insecure or empty
	  * @throws \RangeException if $newPostOffer is >75 characters
	  * @throws \TypeError if $newPostOffer is not a string
	  */
	 public function setPostOffer(string $newPostOffer) {
	 	$newPostOffer = trim($newPostOffer);
	 	$newPostOffer = filter_var($newPostOffer, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	 	if(empty($newPostOffer) === true) {
	 		throw(new \InvalidArgumentException("Offer content is empty or insecure."));
		}
		if(strlen($newPostOffer) > 75) {
	 		throw(new \RangeException("Offer content too large"));
		}
		$this->postOffer = $newPostOffer;
	 }
	 /**
	  * accessor method for post request
	  * @returns string value of post request
	  */
	 public function getPostRequest() {
	 	return($this->postRequest);
	 }
	 /**
	  * mutator method for post request
	  * @param string $newPostRequest new value of post request
	  * @throws \InvalidArgumentException if $newPostRequest is insecure or empty
	  * @throws \RangeException if $newPostRequest is > 75 characters
	  * @throws \TypeError if $newPostRequest is not a string
	  **/
	 public function setPostRequest(string $newPostRequest) {
	 	$newPostRequest = trim($newPostRequest);
	 	$newPostRequest = filter_var($newPostRequest, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	 	if(empty($newPostRequest) === true) {
			throw(new \InvalidArgumentException("Request is empty or insecure"));
		}
		if(strlen($newPostRequest) > 75) {
			throw(new \RangeException("Request is too long"));
		}
		$this->postRequest = $newPostRequest;
	 }
	 /**
	  * accessor method for post timestamp
	  * @returns int $postTimeStamp value of current post timestamp
	  */
	 public function getPostTimestamp() {
	 	return($this->postTimestamp);
	 }

	/**
	 * mutator method for post timestamp
	 *
	 * @param \DateTime|string|null $newPostTimestamp post date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newPostTimestamp is not a valid object or string
	 * @throws \RangeException if $newPostTimestamp is a date that does not exist
	 **/
	public function setPostTimestamp($newPostTimestamp = null) {
		// base case: if the date is null, use the current date and time
		if($newPostTimestamp === null) {
			$this->postTimestamp = new \DateTime();
			return;
		}
		try {
			$newPostTimestamp = self::validateDateTime($newPostTimestamp);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->postTimestamp = $newPostTimestamp;
	}
	/**
	 * inserts this post into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {
		if($this->postId !== null) {
			throw(new \PDOException("Not a new post"));
		}
		$query = "INSERT INTO post(postModeId, postProfileId, postBrowser, postContent, postIpAddress, postLocation, postOffer, postRequest) VALUES(:postModeId, :postProfileId, :postBrowser, :postContent, :postIpAddress, POINT(:postLocationX, :postLocationY), :postOffer, :postRequest)";
		$statement = $pdo->prepare($query);

		$parameters = ["postModeId" => $this->postModeId, "postProfileId" => $this->postProfileId, "postBrowser" =>$this->postBrowser, "postContent" => $this->postContent, "postIpAddress" => $this->postIpAddress, "postLocationX"=>$this->postLocation->getLat(), "postLocationY"=>$this->postLocation->getLong(),"postOffer"=>$this->postOffer, "postRequest"=>$this->postRequest, "postTimestamp" => $this->postTimestamp];

		$statement->execute($parameters);
		//update null messageId
		$this->postId = intval($pdo->lastInsertId());
		$this->postTimestamp = new \DateTime();
	}
	/**
	 * deletes this post from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) {
		if($this->postId === null) {
			throw(new \PDOException("unable to delete a post that doesn't exist"));
		}
		$query = "DELETE FROM post WHERE postId = :postId";
		$statement = $pdo->prepare($query);

		$parameters = ["postId" => $this->postId];
		$statement->execute($parameters);
	}


/**
 * updates this post in mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function update(\PDO $pdo) {
	if($this->postId === null) {
		throw(new \PDOException("Cannot update a post that doesn't exist"));
	}
	$query = "UPDATE post SET postModeId = :postModeId, postProfileId = :postProfileId, postBrowser =:postBrowser, postContent = :postContent, postIpAddress = :postIpAddress, postLocation = POINT(:postLocationX, :postLocationY), postOffer = :postOffer, postRequest = :postRequest, postTimestamp = :postTimestamp";
	$statement = $pdo->prepare($query);

	$parameters = ["postModeId" => $this->postModeId, "postProfileId" => $this->postProfileId, "postBrowser" =>$this->postBrowser, "postContent" => $this->postContent, "postIpAddress" => $this->postIpAddress, "postLocationX"=>$this->postLocation->getLat(), "postLocationY"=>$this->postLocation->getLong(), "postOffer"=>$this->postOffer, "postRequest"=>$this->postRequest, "postTimestamp" => $this->postTimestamp];

	$statement->execute($parameters);
	$this->postTimestamp = new \DateTime();
}

	/**gets the post by post Id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int|string $postId post Id to search
	 * @param \Exception $exception
	 * @return int $postId of one post with that id
	 */

	public static function getPostByPostId (\PDO $pdo, string $postId, $exception) {
		if($postId <= 0) {
			throw(new \RangeException("Post ID must be positive"));
		}
		$query = "SELECT postId, postModeId, postProfileId, postBrowser, postContent, postIpAddress, ST_X(postLocation) AS postLocationX, ST_Y(postLocation) AS postLocationY, postOffer, postRequest, postTimestamp FROM post WHERE postId = :postId";
		$statement = $pdo->prepare($query);

		$parameters = ["postId => $postId"];
		$statement->execute($parameters);

		try {
			$post = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$post = new Post($row["postId"], $row["postModeId"], $row["postProfileId"], $row["postBrowser"], $row["postContent"], $row["postIpAddress"], new Point($row["postLocationX"], $row["postLocationY"]), $row["postOffer"], $row["postRequest"], $row["postTimestamp"]);
			}
			} catch (\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		return($post);
	}
		/**
		 * get post by post mode ID
		 * @param \PDO $pdo connection object
		 * @param int $postModeId mode to search by
		 * @return \SplFixedArray of posts found
		 * @throws \PDOException $exception when mySQL errors occur
		 * @throws \TypeError when variables are not correct type
		 */
		public static function getPostByPostModeId (\PDO $pdo, int $postModeId, $exception) {
			if($postModeId <= 0) {
			throw(new \RangeException("Post mode ID must be positive"));
			}
			if($postModeId >= 3) {
				throw(new \RangeException("Post Mode ID not valid"));
			}
		$query = "SELECT postId, postModeId, postProfileId, postBrowser, postContent, postIpAddress, ST_X(postLocation) AS postLocationX, ST_Y(postLocation) AS postLocationY, postOffer, postRequest, postTimestamp FROM post WHERE postModeId = :postModeId";
		$statement = $pdo->prepare($query);

		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postModeId"], $row["postProfileId"], $row["postBrowser"], $row["postContent"], $row["postIpAddress"], new Point($row["postLocationX"], $row["postLocationY"]), $row["postOffer"], $row["postRequest"], $row["postTimestamp"]);
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($posts);
	}
	/**
	 * get post by post profile ID
	 * @param \PDO $pdo connection object
	 * @param int $postProfileId profile ID to search by
	 * @return \SplFixedArray of posts found
	 * @throws \PDOException $exception when mySQL errors occur
	 * @throws \TypeError when variables are not correct type
	 */
	public static function getPostByPostProfileId (\PDO $pdo, int $postProfileId, $exception) {
		if($postProfileId <= 0) {
			throw(new \RangeException("Post ID must be positive"));
		}
		//create the query template
		$query = "SELECT postId, postModeId, postProfileId, postBrowser, postContent, postIpAddress, ST_X(postLocation) AS postLocationX, ST_Y(postLocation) AS postLocationY, postOffer, postRequest, postTimestamp FROM post WHERE postProfileId = :postProfileId";
		$statement = $pdo->prepare($query);

		//bind the parameters
		$parameters = ["postProfileId" => $postProfileId];
		$statement->execute($parameters);
		//build an array of posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postModeId"], $row["postProfileId"], $row["postBrowser"], $row["postContent"], $row["postIpAddress"], new Point($row["postLocationX"], $row["postLocationY"]), $row["postOffer"], $row["postRequest"], $row["postTimestamp"]);
				$posts[$posts->key()] = $post;
				$posts->next();
			}	catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($posts);
	}
	/**gets the post by content
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $postContent post content to search
	 * @return \SplFixedArray of posts found
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError when variables are not correct type
	 **/

	public static function getPostByPostContent(\PDO $pdo, string $postContent) {
		$postContent = trim($postContent);
		$postContent = filter_var($postContent, FILTER_FLAG_NO_ENCODE_QUOTES, FILTER_SANITIZE_STRING);
		if(empty($postContent) === true) {
			throw(new \PDOException("Post content is invalid"));
		}
		//create new query template
		$query = "SELECT postId, postModeId, postProfileId, postBrowser, postContent, postIpAddress, ST_X(postLocation) AS postLocationX, ST_Y(postLocation) AS postLocationY, postOffer, postRequest, postTimestamp FROM post WHERE postContent LIKE :postContent";
		$statement = $pdo->prepare($query);
		//bind the parameters
		$postContent = "%$postContent%";
		$parameters = ["postContent => $postContent"];
		$statement->execute($parameters);
//build an array of posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postModeId"], $row["postProfileId"], $row["postBrowser"], $row["postContent"], $row["postIpAddress"], new Point($row["postLocationX"], $row["postLocationY"]), $row["postOffer"], $row["postRequest"], $row["postTimestamp"]);
				$posts[$posts->key()] = $post;
				$posts->next();
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($posts);
	}
	/**
	 * gets post by Post Location
	 * @param \PDO $pdo PDO connection object
	 * @param point $postLocation to search by
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct type
	 * @returns \SplFixedArray array of posts that are found
	 **/
	public static function getPostByPostLocation (\PDO $pdo, point $postLocation) {
		//sanitize
		if(empty($postLocation) === true) {
			throw(new \PDOException("Post location is not valid"));
		}
		//create query template
		$query = "SELECT postId, postModeId, postProfileId, postBrowser, postContent, postIpAddress, ST_X(postLocation) AS postLocationX, ST_Y(postLocation) AS postLocationY, postOffer, postRequest, postTimestamp FROM post WHERE postLocation = :postLocation";
		$statement = $pdo->prepare($query);
		//bind parameters
		$parameters = ["postLocation => $postLocation"];
		$statement->execute($parameters);
		//create an array of posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postModeId"], $row["postProfileId"], $row["postBrowser"], $row["postContent"], $row["postIpAddress"], new Point($row["postLocationX"], $row["postLocationY"]), $row["postOffer"], $row["postRequest"], $row["postTimestamp"]);
				$posts[$posts->key()] = $post;
				$posts->next();
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($posts);
	}
	/**
	 * get post by post offer
	 * @param \PDO $pdo connection object
	 * @param string $postOffer to search by
	 * @return \SplFixedArray of posts found
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError when variables are not correct type
	 */
	public static function getPostByPostOffer (\PDO $pdo, string $postOffer, $exception) {
		$postOffer = trim($postOffer);
		$postOffer = filter_var($postOffer, FILTER_FLAG_NO_ENCODE_QUOTES, FILTER_SANITIZE_STRING);
		if(empty($postOffer) === true) {
			throw(new \PDOException("Post Offer is invalid"));
		}
		$query = "SELECT postId, postModeId, postProfileId, postBrowser, postContent, postIpAddress, ST_X(postLocation) AS postLocationX, ST_Y(postLocation) AS postLocationY, postOffer, postRequest, postTimestamp FROM post WHERE postOffer LIKE :postOffer";
		$statement = $pdo->prepare($query);
//bind the parameters
		$postOffer = "%$postOffer%";
		$parameters = ["postOffer => $postOffer"];
		$statement->execute($parameters);
		//make an array
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postModeId"], $row["postProfileId"], $row["postBrowser"], $row["postContent"], $row["postIpAddress"], new Point($row["postLocationX"], $row["postLocationY"]), $row["postOffer"], $row["postRequest"], $row["postTimestamp"]);
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($posts);
	}

	/**
	 * get post by post request
	 * @param \PDO $pdo connection object
	 * @param string $postRequest to search by
	 * @param $exception
	 * @return \SplFixedArray of posts found
	 */
	public static function getPostByPostRequest (\PDO $pdo, string $postRequest, $exception) {
		$postRequest = trim($postRequest);
		$postRequest = filter_var($postRequest, FILTER_FLAG_NO_ENCODE_QUOTES, FILTER_SANITIZE_STRING);
		if(empty($postRequest) === true) {
			throw(new \PDOException("Post Request is invalid"));
		}
		$query = "SELECT postId, postModeId, postProfileId, postBrowser, postContent, postIpAddress, ST_X(postLocation) AS postLocationX, ST_Y(postLocation) AS postLocationY, postOffer, postRequest, postTimestamp FROM post WHERE postRequest LIKE :postRequest";
		$statement = $pdo->prepare($query);
//bind the parameters
		$postRequest = "%$postRequest%";
		$parameters = ["postRequest => $postRequest"];
		$statement->execute($parameters);
		//make an array
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postModeId"], $row["postProfileId"], $row["postBrowser"], $row["postContent"], $row["postIpAddress"], new Point($row["postLocationX"], $row["postLocationY"]), $row["postOffer"], $row["postRequest"], $row["postTimestamp"]);
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($posts);
	}
	/**
	 * get post by post request
	 * @param \PDO $pdo connection object
	 * @param int $postTimestamp to search by
	 * @param $exception
	 * @return \SplFixedArray of posts found
	 */
	public static function getPostByPostTimestamp (\PDO $pdo, int $postTimestamp, $exception) {
		if(($postTimestamp) === null) {
			throw(new \PDOException("Post Timestamp is null"));
		}
		$query = "SELECT postId, postModeId, postProfileId, postBrowser, postContent, postIpAddress, ST_X(postLocation) AS postLocationX, ST_Y(postLocation) AS postLocationY, postOffer, postRequest, postTimestamp FROM post WHERE postTimestamp >= :sunrise AND postTimestamp <= :sunset";
		$statement = $pdo->prepare($query);
//bind the parameters
		$parameters = ["postTimestamp => $postTimestamp"];
		$statement->execute($parameters);
		//make an array
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postModeId"], $row["postProfileId"], $row["postBrowser"], $row["postContent"], $row["postIpAddress"], new Point($row["postLocationX"], $row["postLocationY"]), $row["postOffer"], $row["postRequest"], $row["postTimestamp"]);
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($posts);
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