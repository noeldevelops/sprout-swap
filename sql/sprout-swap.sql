-- these statements will drop the tables and re-add them
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS message;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS mode;

CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileImageId REFERENCES image (imageId),
	profileActivation CHAR,
	profileEmail VARCHAR NOT NULL (255),
	profileHandle VARCHAR NOT NULL (15),
	profileJoinDate TIMESTAMP NOT NULL,
	profileName VARCHAR (30),
	profilePasswordHash CHAR (128),
	profileSalt CHAR (64),
	profileSummary VARCHAR (250),

	PRIMARY KEY (profileId)
);

CREATE TABLE post (
	postId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	postModeId REFERENCES mode (modeId),
	postProfileId REFERENCES profile (profileId),
	postContent VARCHAR (250),
	postDateTime TIMESTAMP NOT NULL,
	postLocation POINT,
	postOffer VARCHAR NOT NULL(75),
	postRequest VARCHAR (75),

	PRIMARY KEY (postId)
);

CREATE TABLE message (
	messageId,
	messagePostId REFERENCES post (postId),
	messageReceiverProfileId,
	messageSenderProfileId,
	messageBrowser,
	messageContent,
	messageIpAddress,
	messageStatus,
	messageTimeStamp
);

CREATE TABLE image (
	imageId,
	imagePostId,
	imageCloudinaryId
);

CREATE TABLE mode (
	modeId,
	modeName
);