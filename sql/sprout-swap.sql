-- noinspection SqlDialectInspectionForFile

-- noinspection SqlNoDataSourceInspectionForFile

-- these statements will drop the tables and re-add them

DROP TABLE IF EXISTS message;
DROP TABLE IF EXISTS postImage;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS mode;
DROP TABLE IF EXISTS image;

CREATE TABLE image (
	imageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	imageCloudinaryId VARCHAR (32),

	PRIMARY KEY (imageId)
);

CREATE TABLE mode (
	modeId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	modeName VARCHAR (20),

	PRIMARY KEY (modeId)
);


CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileImageId INT UNSIGNED NOT NULL,
	profileActivation CHAR (16),
	profileEmail VARCHAR (255) NOT NULL,
	profileHandle VARCHAR (21) NOT NULL,
	profileTimestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	profileName VARCHAR (30),
	profilePasswordHash CHAR (128),
	profileSalt CHAR (64),
	profileSummary VARCHAR (255),

	FOREIGN KEY (profileImageId) REFERENCES image (imageId),
	PRIMARY KEY (profileId)
);

CREATE TABLE post (
	postId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	postModeId INT UNSIGNED NOT NULL,
	postProfileId INT UNSIGNED NOT NULL,
	postBrowser VARCHAR (255) NOT NULL,
	postContent VARCHAR (250),
	postIpAddress VARBINARY (16),
	postLocation POINT NOT NULL,
	postOffer VARCHAR (75) NOT NULL,
	postRequest VARCHAR (75),
	postTimestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,

	FOREIGN KEY (postModeId) REFERENCES mode (modeId),
	FOREIGN KEY (postProfileId) REFERENCES profile (profileId),
	PRIMARY KEY (postId)
);

CREATE TABLE postImage(
	postImageImageId INT UNSIGNED NOT NULL,
	postImagePostId INT UNSIGNED NOT NULL,

	FOREIGN KEY (postImageImageId) REFERENCES image (imageId),
	FOREIGN KEY (postImagePostId) REFERENCES post (postId)
);

	CREATE TABLE message (
	messageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	messagePostId INT UNSIGNED NOT NULL,
	messageReceiverProfileId INT UNSIGNED NOT NULL,
	messageSenderProfileId INT UNSIGNED NOT NULL,
	messageBrowser VARCHAR (255) NOT NULL,
	messageContent VARCHAR (500) NOT NULL,
	messageIpAddress VARBINARY (16),
	messageStatus TINYINT NOT NULL,
	messageTimestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,

	FOREIGN KEY (messagePostId) REFERENCES post (postId),
	FOREIGN KEY (messageReceiverProfileId) REFERENCES profile (ProfileId),
	FOREIGN KEY (messageSenderProfileId) REFERENCES profile (profileId),
	PRIMARY KEY (messageId)
);


