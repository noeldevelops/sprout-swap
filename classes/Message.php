<?PHP

class Message{
	/*
	 * ID for message; primary key
	 * @var int $messageId
	 */
	private $messageId;
	/*
	 * ID for message in reference to a certain post; foreign key
	 * @var int $messagePostId
	 */
	private $messagePostId;
	/*
	 * ID for profile receiving the message; foreign key
	 * @var int $messageReceiverProfileId
	 */
	private $messageReceiverProfileId;
	/*
	 * ID for profile sending the message
	 * @var int $messageSenderProfileId
	 */
	private $messageSenderProfileId;
	/*
	 * Information about the user's browser
	 * @var $messageBrowser VARCHAR (255)
	 */
	private $messageBrowser;
	/*
	 * content of the message
	 * @var $messageContent VARCHAR (255)
	 */
	private $messageContent;
	/*
	 * IP address of message sender
	 * @var $browserIpAddress VARBINARY (16)
	 */
	private $messageIpAddress;
	/*
	 * Whether the message is read or unread
	 * @var $messageStatus TINYINT NOT NULL
	 */
	private $messageStatus;
	/*
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
}