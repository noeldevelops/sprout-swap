<?PHP

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

	public function __construct(int $postImageImageId, int $postImagePostId) {
		try{
			$this->setPostImageImageId($postImageImageId);
			$this->setPostImagePostId($postImagePostId);
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
	 * @param int $postImageImageId
	 * @throws \RangeException if postImageImageId is less than or equal to zero
	 */
	public function setPostImageImageId(int $postImageImageId) {
		if($this->postImageImageId >= 0){
			throw(new \RangeException("postImageImageId must be greater than zero"));
		}
		$this->postImageImageId = $postImageImageId;
	}

	/**
	 * accessor method for postImagePostId
	 * @return int
	 */
	public function getPostImagePostId(){
		return $this->postImagePostId;
	}
	/**
	 * @param int $postImagePostId
	 * @throws RangeException if postImagePostId is less than or equal to zero
	 */
	public function setPostImagePostId(int $postImagePostId){
		if($this->postImagePostId >= 0){
			throw(new \RangeException("postImageImageId must be greater than zero"));
		}
		$this->postImagePostId = $postImagePostId;
	}


}