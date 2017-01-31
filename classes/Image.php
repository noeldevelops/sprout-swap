<?php
/**
 * This class is for images that users upload
 *
 * @author A Noel Cothren <noelcothren@gmail.com>
 * @version 1.0
 **/
class Image implements \JsonSerializable {
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
	 * @param int|null $newImageCloudinaryId id of the image on Cloudinary API
	 * @throws \TypeError if data violates type hints
	 * @throws \Exception if some other exception occurs
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are negative or too long
	 */
	public function __contruct(int $newImageId = null, int $newImageCloudinaryId) {
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
}