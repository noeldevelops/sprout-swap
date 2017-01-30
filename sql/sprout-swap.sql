-- these statements will drop the tables and re-add them
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS message;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS mode;

CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileImageId INT UNSIGNED NOT NULL,
	profileActivation CHAR,
	profileEmail VARCHAR NOT NULL (255),
	profileHandle VARCHAR NOT NULL (15),
	profileJoinDate TIMESTAMP NOT NULL,
	profileName VARCHAR (30),
	profilePasswordHash CHAR (128),
	profileSalt CHAR (64),
	profileSummary VARCHAR (250),

	-- FOREIGN KEY (profileImageId) REFERENCES image (imageId),
	PRIMARY KEY (profileId)
);

CREATE TABLE post (
	postId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	postModeId INT UNSIGNED NOT NULL,
	postProfileId INT UNSIGNED NOT NULL,
	postContent VARCHAR (250),
	postDateTime TIMESTAMP NOT NULL,
	postLocation POINT NOT NULL,
	postOffer VARCHAR NOT NULL(75),
	postRequest VARCHAR (75),

	FOREIGN KEY (postModeId) REFERENCES mode (modeId),
	FOREIGN KEY (postProfileId) REFERENCES profile (profileId),
	PRIMARY KEY (postId)
);

CREATE TABLE message (
	messageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	messagePostId INT UNSIGNED NOT NULL,
	messageReceiverProfileId INT UNSIGNED NOT NULL,
	messageSenderProfileId INT UNSIGNED NOT NULL,
	messageBrowser ,
	messageContent VARCHAR NOT NULL (500),
	messageIpAddress,
	messageStatus,
	messageTimeStamp TIMESTAMP NOT NULL,

	FOREIGN KEY (messagePostId) REFERENCES post (postId),
	FOREIGN KEY (messageReceiverProfileId) REFERENCES profile (ProfileId),
	FOREIGN KEY (messageSenderProfileId) REFERENCES profile (profileId),
	PRIMARY KEY (messageId)
);

CREATE TABLE image (
	imageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	imagePostId INT UNSIGNED NOT NULL,
	imageCloudinaryId,

	FOREIGN KEY (imagePostId) REFERENCES image (imageId),
	PRIMARY KEY (imageId)
);

CREATE TABLE mode (
	modeId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	modeName VARCHAR (20),

	PRIMARY KEY (modeId)
);