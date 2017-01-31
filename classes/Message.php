<?PHP

class Message implements \JsonSerializable {
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
	 * @var $messageBrowser string (255)
	 */
	private $messageBrowser;
	/**
	 * content of the message
	 * @var $messageContent string (255)
	 */
	private $messageContent;
	/**
	 * IP address of message sender
	 * @var $browserIpAddress VARBINARY (16)
	 */
	private $messageIpAddress;
	/**
	 * Whether the message is read or unread
	 * @var $messageStatus int NOT NULL
	 */
	private $messageStatus;
	/**
	 * Timestamp when message was sent
	 * @var $messageTimeStamp DEFAULT CURRENT_TIMESTAMP NOT NULL
	 */
	private $messageTimestamp;

	public function __construct
	(int $newMessageId = null, int $newMessagePostId, int $newMessageReceiverProfileId, int $newMessageSenderProfileId, string $newMessageBrowser, string $newMessageContent, string $newMessageIpAddress, int $newMessageStatus, $newMessageTimestamp = null) {
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
	 * @throws \RangeException if Id is equal to or less than zero
	 */
	public function setMessageSenderProfileId(int $newMessageSenderProfileId){
		//check that messageSenderProfileId is above zero
		if($newMessageSenderProfileId <= 0){
			throw(new \RangeException("messageSenderProfileId must be greater than 0"));
		}
		//convert and store variable
		$this->messageSenderProfileId = $newMessageSenderProfileId;
	}
	/**
	 * accessor method for message sender's browser
	 * @return string
	 */
	public function getMessageBrowser(){
		return($this->messageBrowser);
	}
	/**
	 * mutator method for message sender's browser information
	 * @param string $newMessageBrowser
	 * @throws \Exception if no information received from sender
	 */
	public function setMessageBrowser(string $newMessageBrowser){
		//sanitize input
		$newMessageBrowser = trim($newMessageBrowser);
		$newMessageBrowser = filter_var($newMessageBrowser, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		//if null, no information recorded from the user
		if($newMessageBrowser === null){
			throw(new \Exception("No browser information received"));
		}
		//convert and store information
		$this->messageBrowser = $newMessageBrowser;
	}
	/**
	 * accessor method for message content
	 * @return string message content
	 */
	public function getMessageContent(){
		return($this->messageContent);
	}
	/**
	 * mutator method for message content
	 * @param string $newMessageContent
	 * @throws \InvalidArgumentException if user attempts to send a blank message
	 * @throws \RangeException if message is too long to fit in the database
	 */
	public function setMessageContent(string $newMessageContent){
		//filters message content to ensure security
		$newMessageContent = trim($newMessageContent);
		$newMessageContent = filter_var($newMessageContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		//throws exception if user sends a blank message
		if(empty($newMessageContent) === true){
			throw(new \InvalidArgumentException("Messages cannot be blank!"));
		}
		//ensure message will fit into the database
		if(strlen($newMessageContent) > 500){
			throw(new \RangeException("Messages cannot contain more than 500 characters!"));
		}
		//converts and stores content
		$this->messageContent = $newMessageContent;
	}
	/**
	 * accessor method for message sender's ip address
	 * @return string
	 */
	public function getMessageIpAddress(){
		return($this->messageIpAddress);
	}
	/**
	 * mutator method for message sender's ip address
	 * @param $newMessageIpAddress
	 * @throws TypeError
	 */
	public function setMessageIpAddress(string $newMessageIpAddress) {
		//sanitize input
		$newMessageIpAddress = trim($newMessageIpAddress);
		$newMessageIpAddress = filter_var($newMessageIpAddress, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		//if null, throws TypeError
		if($newMessageIpAddress === null) {
			throw(new \TypeError("Ip address must be a string"));
		}
		//convert and store string
		$this->messageIpAddress = $newMessageIpAddress;
	}
	/**
	 * accessor method for message status (read or unread)
	 * @return int either 0 or 1
	 */
		public function getMessageStatus(){
			return($this->messageStatus);
		}
	/**
	 * mutator method for message status
	 * @param int $newMessageStatus
	 * throws \RangeException if not equal to either zero or one
	 */
		public function setMessageStatus(int $newMessageStatus){
			//throws exceptions if $newMessageStatus is NOT equal to 0 or 1
			if($newMessageStatus !== 0 || $newMessageStatus !== 1){
				throw (new \RangeException("Message Status must be equal to either zero or one"));
			}
			//convert and store variable
			$this->messageStatus = $newMessageStatus;
		}
	/**
	 * accessor for message timestamp
	 * @returns $messageTimestamp
	 */
		public function getMessageTimestamp(){
			return($this->messageTimestamp);
		}
	/**
	 * mutator for messageTimestamp
	 * @param null $newMessageTimestamp
	 */
		public function setMessageTimestamp($newMessageTimestamp = null){
			// if message timestamp is null, set it to current
			if($newMessageTimestamp === null){
				$this->messageTimestamp = new DateTime();
				return;
			}
			// store message date
			try{
				$newMessageTimestamp = self::validateDateTime($newMessageTimestamp);
			} catch(\InvalidArgumentException $invalidArgument) {
				throw (new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
			} catch(\RangeException $rangeException) {
				throw (new \RangeException($rangeException->getMessage(), 0, $rangeException));
			}
			$this->messageTimestamp = $newMessageTimestamp;
		}

	/**
	 * insert function
	 * @param PDO $pdo
	 */
		public function insert (\PDO $pdo){
			//ensure message id is null
			if($this->messageId !==  null){
				throw (new \PDOException("messageId already exists in database"));
			}
			// create query template
			$query = "INSERT INTO message(messagePostId, messageReceiverProfileId, messageSenderProfileId, messageBrowser, messageContent, messageIpAddress, messageStatus, messageTimestamp)";
			$statement = $pdo->prepare($query);
			//bind variables
			$formattedTimestamp = $this->messageTimestamp->format("Y-m-d H:i:s");
			$parameters = ["messagePostId" => $this->messagePostId, "messageReceiveProfilerId" => $this->messageReceiverProfileId, "messageSenderProfileId" => $this->messageSenderProfileId, "messageBrowser" => $this->messageBrowser, "messageContent" => $this->messageContent, "messageIpAddress" => $this->messageIpAddress, "messageStatus" => $this->messageStatus, "messageTimestamp" => $formattedTimestamp];
			$statement->execute($parameters);
			//update null messageId
			$this->messageId = intval($pdo->lastInsertId());
		}
	/**
	 * delete function for mySQL
	 * @param PDO $pdo
	 */
		public function delete (\PDO $pdo){
			//if messageId is null, it does not exist and therefore cannot be deleted
			if($this->messageId ===  null){
				throw (new \PDOException("cannot delete a message without an assigned messageId"));
			}
			// create query
			$query = "DELETE FROM message WHERE messageId = $this->messageId";
			$statement = $pdo->prepare($query);
			//bind variables to template
			$parameters = ["messageId" => $this->messageId];
			//execute parameters
			$statement->execute($parameters);
		}

	/**
	 * update method for message
	 * @param PDO $pdo
	 */
		public function update(\PDO $pdo) {
			//if messageId is null, it does not exist and therefore cannot be updated
			if($this->messageId === null) {
				throw(new \PDOException("cannot update a message that does not have an assigned messageId"));
			}
			//create query template
			$query = "UPDATE message SET messagePostId = :messagePostId, messageReceiverProfileId = :messageReceiverProfileId, messageSenderProfileId = :messageSenderProfileId, messageBrowser = :messageBrowser, messageContent = :messageContent, messageIpAddress = :messageIpAddress, messageStatus = :messageStatus, messageTimestamp = :messageTimestamp WHERE messageId = :messageId";
			$statement = $pdo->prepare($query);
			//bind variables
			$formattedTimestamp = $this->messageTimestamp->format("Y-m-d H:i:s");
			$parameters = ["messagePostId" => $this->messagePostId, "messageReceiveProfilerId" => $this->messageReceiverProfileId, "messageSenderProfileId" => $this->messageSenderProfileId, "messageBrowser" => $this->messageBrowser, "messageContent" => $this->messageContent, "messageIpAddress" => $this->messageIpAddress, "messageStatus" => $this->messageStatus, "messageTimestamp" => $formattedTimestamp];
			//execute parameters
			$statement->execute($parameters);
		}

	/**
	 * @param PDO $pdo
	 * @param int $messageSenderProfileId
	 * @return SplFixedArray of all messages associated with a sender id
	 * @throws \PDOException when mySQL errors occur
	 * @throws \RangeException when messageProfileId is of the incorrect type or less than zero
	 */
		public function getMessageByMessageSenderId(\PDO $pdo, int $messageSenderProfileId){
			//throw an exception if sender id is empty
			if($messageSenderProfileId <= 0){
				throw (\RangeException("messageSenderId is not greater than zero"));
			}
			//create query template
			$query = "SELECT messageId, messagePostId, messageReceiverProfileId, messageSenderProfileId, messageBrowser, messageContent, messageIpAddress, messageStatus, messageTimestamp FROM message WHERE messageSenderProfileId = :messageSenderProfileId";
			$statement = $pdo->prepare($query);
			//bind variables to template
			$parameters = ["messageSenderProfileId" => $messageSenderProfileId];
			$statement->execute($parameters);
			//build array of messages
			$messages = new \SplFixedArray($statement->rowCount());
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			while(($row = $statement->fetch()) !== false){
				try{
					$message = new Message($row["messageId"], $row["messagePostId"], $row["messageReceiverProfileId"], $row["messageSenderProfileId"], $row["messageBrowser"], $row["messageContent"], $row["messageIpAddress"], $row["messageStatus"], $row["messageTimestamp"]);
					$messages[$messages->key()] = $message;
					$messages->next();
				} catch(\Exception $exception){
					//throws if row can't be converted
					throw (new \PDOException($exception->getMessage(), 0, $exception));
				}
				return($messages);
			}
		}
	/**
	 * formats variables for JSON serialization
	 * @return array with state variable to serialize
	 */
		public function jsonSerialize(){
			$fields = get_object_vars($this);
			$fields["messageTimestamp"] = $this->messageTimestamp->getTimestamp() * 1000;
			return($fields);
		}
}