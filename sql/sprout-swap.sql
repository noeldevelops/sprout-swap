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
	profileImageId INT UNSIGNED,
	profileActivation VARCHAR (64),
	profileEmail VARCHAR (255) NOT NULL,
	profileHandle VARCHAR (21) NOT NULL,
	profileTimestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	profileName VARCHAR (30),
	profilePasswordHash CHAR (128),
	profileSalt CHAR (64),
	profileSummary VARCHAR (255),

	UNIQUE (profileEmail),
	UNIQUE (profileHandle),
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
	messagePostId INT UNSIGNED,
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

INSERT INTO mode (modeId, modeName) VALUES (1, "free");
INSERT INTO mode (modeId, modeName) VALUES (2, "trade");
INSERT INTO mode (modeId, modeName) VALUES (3, "sell");

-- this stored procedure was written by Zak Abad.
-- with guidance and mathematics/statistics help from Dylan McDonald. @dylan-mcdonald

DROP PROCEDURE IF EXISTS getPostsByPostLocation;
DELIMITER $$
CREATE PROCEDURE getPostsByPostLocation(IN userLocation POINT, IN userDistance FLOAT)
	BEGIN
		DECLARE varPostId INT UNSIGNED;
		DECLARE varPostModeId INT UNSIGNED;
		DECLARE varPostProfileId INT UNSIGNED;
		DECLARE varPostBrowser VARCHAR (255);
		DECLARE varPostContent VARCHAR (250);
		DECLARE varPostIpAddress VARBINARY (16);
		DECLARE varPostLocation POINT;
		DECLARE varPostOffer VARCHAR (75);
		DECLARE varPostRequest VARCHAR (75);
		DECLARE varPostTimestamp TIMESTAMP;
		DECLARE varPostDistance FLOAT;

		DECLARE done BOOLEAN DEFAULT FALSE;
		DECLARE postCursor CURSOR FOR
			SELECT postId, postModeId, postProfileId, postBrowser, postContent, postIpAddress, postLocation, postOffer, postRequest, postTimestamp FROM post;
		 DECLARE CONTINUE HANDLER FOR NOT FOUND
			 SET done = TRUE;

		DROP TEMPORARY TABLE IF EXISTS selectedPost;
		CREATE TEMPORARY TABLE selectedPost(
			postId INT UNSIGNED NOT NULL,
			postModeId INT UNSIGNED NOT NULL,
			postProfileId INT UNSIGNED NOT NULL,
			postBrowser VARCHAR (255) NOT NULL,
			postContent VARCHAR (250),
			postIpAddress VARBINARY (16),
			postLocationX FLOAT NOT NULL,
			postLocationY FLOAT NOT NULL,
			postOffer VARCHAR (75) NOT NULL,
			postRequest VARCHAR (75),
			postTimestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
			postDistance FLOAT
		);
		OPEN postCursor; -- open cursor
		postLoop : LOOP

			FETCH postCursor INTO
				varPostId,
				varPostModeId,
				varPostProfileId,
				varPostBrowser,
				varPostContent,
				varPostIpAddress,
				varPostLocation,
				varPostOffer,
				varPostRequest,
				varPostTimestamp;


			SET varPostDistance = haversine(varPostLocation, userLocation);
			INSERT INTO selectedPost(postId, postModeId, postProfileId, postBrowser, postContent, postIpAddress, postLocationX, postLocationY, postOffer, postRequest, postTimestamp, postDistance) VALUES (varPostId, varPostModeId, varPostProfileId,varPostBrowser, varPostContent, varPostIpAddress, ST_X(varPostLocation), ST_Y(varPostLocation), varPostOffer, varPostRequest, varPostTimestamp, varPostDistance);


			IF done THEN LEAVE postLoop; -- leaves rows
			END IF;
		END LOOP postLoop;
		CLOSE postCursor;

		SELECT postId, postModeId, postProfileId, postBrowser, postContent, postIpAddress, postLocationX, postLocationY, postOffer, postRequest, postTimestamp, postDistance
		FROM selectedPost
		WHERE postDistance <= userDistance
		ORDER BY postDistance;

	END $$
DELIMITER ;