<?PHP

class Message{
	/**
	 * ID for message; primary key
	 * @var int $messageId
	 */
	private $messageId;
	/**
	 * ID for message in reference to a certain post; foreign key
	 * @var int $messagePostId
	 */
	private $messagePostId;
	/**
	 * ID for profile receiving the message; foreign key
	 * @var int $messageReceiverProfileId
	 */
	private $messageReceiverProfileId;
	/**
	 * ID for profile sending the message
	 * @var int $messageSenderProfileId
	 */
	private $messageSenderProfileId;
	/**
	 * Information about the user's browser
	 * @var $messageBrowser VARCHAR (255)
	 */
	private $messageBrowser;
	/**
	 * content of the message
	 * @var $messageContent VARCHAR (255)
	 */
	private $messageContent;
	/**
	 * IP address of message sender
	 * @var $browserIpAddress VARBINARY (16)
	 */
	private $messageIpAddress;
	/**
	 * Whether the message is read or unread
	 * @var $messageStatus TINYINT NOT NULL
	 */
	private $messageStatus;
	/**
	 * Timestamp when message was sent
	 * @var $messageTimeStamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
	 */
	private $messageTimestamp;

	public function __construct(int $newMessageId = null, int $newMessagePostId, int $newMessageReceiverProfileId, int $newMessageSenderProfileId, string $newMessageBrowser, string $newMessageContent,  $newMessageIpAddress, int $newMessageStatus, $newMessageTimestamp = null) {
		try{
			$this->setMessageId($newMessageId);
			$this->setMessagePostId($newMessagePostId);
			$this->setMessageReceiverProfileId($newMessageReceiverProfileId);
			$this->setMessageSenderProfileId($newMessageSenderProfileId);
			$this->setMessageBrowser($newMessageBrowser);
			$this->setMessageContent($newMessageContent);
			$this->setMessageIpAddress($newMessageIpAddress);
			$this->setMessageStatus($newMessageStatus);
			$this->setMessageTimestamp($newMessageTimestamp);
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
	 * accessor method for messageId
	 * @return int|null value of messageId
	 */
	public function getMessageId(){
		return($this->messageId);
	}
	/**
	 * mutator method for message id
	 * @param int|null $newMessageId
	 * @throws \RangeException is message id is not positive
	 */
	public function setMessageId(int $newMessageId = null){
		// if message id is null, this is a new message without an assigned id in the database
		if($newMessageId === null){
			$this->messageId = null;
			return;
		}
		// verify message id is positive
		if($newMessageId <= 0){
			throw (new \RangeException("Message Id must be positive"));
		}
		// convert and store message id
		$this->messageId = $newMessageId;
	}
	/**
	 * accessor method for Message post id (message in reference to a certain post)
	 * @return int $messagePostId
	 */
	public function getMessagePostId(){
		return($this->messagePostId);
	}
	/**
	 * mutator method for messagePostId
	 * @param int $newMessagePostId
	 * @throws \RangeException if id is negative or zero
	 */
	public function setMessagePostId(int $newMessagePostId){
		//if null, then this is a new message not in reference to any particular post
		if($newMessagePostId === null){
			return;
		}
		//throws exception if messagePostId is negative or zero
		if($newMessagePostId <= 0){
			throw(new \RangeException("message ID must be either null or greater than 0"));
		}
		// convert and store $messagePostId if message is in reference to a post
		$this->messagePostId = $newMessagePostId;
	}

	/**
	 * accessor method for message receiver's profile id
	 * @return int $messageReceiverProfileId
	 */
	public function getMessageReceiverProfileId(){
		return($this->messageReceiverProfileId);
	}
	/**
	 * mutator method for messageReceiverProfileId
	 * @param int $messageReceiverProfileId
	 */
	public function setMessageReceiverProfileId(int $messageReceiverProfileId) {
		//ensuring $messageReceiverProfileId is greater than 0
		if($messageReceiverProfileId <= 0){
			throw (new \RangeException("Receiver profile Id must be greater than 0"));
		}
		//convert and store value
		$this->messageReceiverProfileId = $messageReceiverProfileId;
	}
	/**
	 * accessor method for message sender Id
	 * @return int messageSenderProfileId
	 */
	public function getMessageSenderProfileId(){
		return($this->messageSenderProfileId);
	}
	/**
	 * mutator method for message sender Id
	 * @param int $newMessageSenderProfileId
	 * @throws \RangeException if Id is equl to or less than zero
	 */
	public function setMessageSenderProfileId(int $newMessageSenderProfileId){
		//check that messageSenderProfileId is above zero
		if($newMessageSenderProfileId <= 0){
			throw(new \RangeException("messageSenderProfileId must be greater than 0"));
		}
		//convert and store variable
		$this->messageSenderProfileId = $newMessageSenderProfileId;
	}
}