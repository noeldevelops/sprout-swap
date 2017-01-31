<?php
/**
 * This class is what is stored when users create a new Post
 *
 * @author A Noel Cothren <noelcothren@gmail.com>
 * @version 1.0
 **/

class Post implements \JsonSerializable {
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
	 * @var VARCHAR $postBrowser
	 */
	private $postBrowser;
	/**
	 * actual content of the post
	 * @var VARCHAR $postContent
	 */
	private $postContent;
	/**
	 *IP Address from the User who is creating post
	 *@var VARBINARY $postContent
	 **/
	private $postIpAddress;
	/**
	 * geolocation of user who creates post
	 * @var POINT $postLocation
	 */
	private $postLocation;
	/**
	 * this is the specific item(s) user is offering
	 * @var VARCHAR $postOffer
	 */
	private $postOffer;
	/**
	 * what is the user requesting in return for offer
	 * @var VARCHAR $postRequest
	 */
	private $postRequest;
	/**
	 * Timestamp when post is created
	 * @var TIMESTAMP $postTimestamp
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
	 * @param string $newPostLocation geolocation of user who created post
	 * @param string $newPostOffer string containing user's offer
	 * @param string $newPostRequest string containing user's request
	 * @param DateTime $newPostTimestamp contains date and time post was created
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	 public function __construct(int $newPostId = null, int $newPostModeId, int $newPostProfileId, string $newPostBrowser, string $newPostContent, string $newPostIpAddress, string $newPostLocation, string $newPostOffer, string $newPostRequest, DateTime $newPostTimestamp ) {
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
	 public function setPostId(int $newPostID = null) {
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
	  * mutuator method for post browser
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
	  * @param string $newPostContent new value of psot content
	  * @throws \InvalidArgumentException if $newPostContent is insecure
	  * @throws \RangeException if $newPostContent is > 250 characters
	  * @throws \TypeError if $newPostContent is not a string
	  **/
	 public function setPostContent(string $newPostContent) {
	 	$newPostContent = trim($newPostContent);
	 	$newPostContent = filter_var($newPostContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	 	if(empty($newPostContent) === true) {
	 			throw(new \InvalidArgumentException("Your post is empty or insecure."));
		if(strlen($newPostContent) > 255) {
			throw(new \RangeException("Your post content is far too wordy."));
		}
		$this->postContent = $newPostContent;
		}
	 }
	 /**
	  * accessor method for postIpAddress
	  * @returns string value of users IP address
	  */
	 public function getPostIpAddress () {
	 	return($this->postIpAddress);
	 }
	 /**
	  * mutuator method for Post IP Address
	  * @param string $newPostIpAddress value of users IP Address
	  * @throws \InvalidArgumentException if IP address is not a valid ip address
	  */
	 public function setPostIpAddress(string $newPostIpAddress) {
	 	$newPostIpAddress = filter_var($newPostIpAddress, FILTER_VALIDATE_IP);
	 	$this->postIpAddress = $newPostIpAddress;
	 }
	 /**
	  * accessor method for post location
	  * @returns point value of post location
	  */
	 public function getPostLocation() {
	 	return($this->postLocation);
	 }
	 /**
	  * mutator method for post location
	  * @param point $newPostLocation new value of post location
	  *
	  */
	 public function setPostLocation(point $newPostLocation) {
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
}