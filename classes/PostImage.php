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


}