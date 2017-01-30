<?php

class Profile {
	/**
	 * id for the profile; this is a primary key
	 * @var int for profileId
	 **/
	private $profileId;
	/**
	 * id for profileImageId
	 * this is a foreign key that references image (imageId)
	 * @var int $profileImageId
	 **/
	private $profileImageId;
	/**
	 * activation code will be sent to end users email
	 * @var is a char(16)
	 **/
	private $profileActivation;
	/**
	 *
	 **/
}
