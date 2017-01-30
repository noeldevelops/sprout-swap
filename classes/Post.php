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
	 }
}