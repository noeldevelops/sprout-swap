-- these statements will drop the tables and re-add them
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS message;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS mode;

CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileActivation CHAR,
	profileEmail VARCHAR NOT NULL,
	profileHandle VARCHAR NOT NULL,
	profileImageId INT,
	profileJoinDate DATETIME,
	profileName VARCHAR,
	profilePasswordHash CHAR,
	profileSalt CHAR,
	profileSummary VARCHAR,

	PRIMARY KEY (profileId)
);

CREATE TABLE post (
	postId INT,
	postModeId,
	postProfileId,
	postContent,
	postDateTime,
	postLocation,
	postOffer VARCHAR,
	postRequest,
);

CREATE TABLE message (
	messageId,
	messagePostId,
	messageReceiverProfileId,
	messageSenderProfileId,
	messageBrowser,
	messageContent,
	messageIpAddress,
	messageStatus,
	messageTimeStamp,
);

CREATE TABLE image (
	imageId,
	imagePostId,
	imageCloudinaryId,
);

CREATE TABLE mode (
	modeId,
	modeName,
);