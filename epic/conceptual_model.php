<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Conceptual Model</title>
	</head>
	<body>
		<h1>Conceptual Model</h1>
		<h2>Key Key</h2>
		<p><strong>Primary keys are bold</strong></p>
		<p><em>Foreign Keys are italic</em></p>
		<h2>Profile</h2>
		<ul>
			<li><strong>profileId (int)</strong></li>
			<li>profileActivation (char)</li>
			<li>profileEmail (varchar)</li>
			<li>profileHandle (varchar)</li>
			<li>profileImageId (int)</li>
			<li>profileJoinDate (datetime)</li>
			<li>profileName (varchar)</li>
			<li>profilePasswordHash (char)</li>
			<li>profileSalt (char)</li>
			<li>profileSummary (varchar)</li>
		</ul>
		<h2>Post</h2>
		<ul>
			<li><strong>postId (int)</strong></li>
			<li><em>postModeId</em></li> <!-- for sale, trade, free-->
			<li><em>postProfileId</em></li>
			<li>postContent (varchar)</li>
			<li>postDateTime (datetime)</li>
			<li>postLocation (point)</li>
			<li>postOffer (varchar)</li>
			<li>postRequest (varchar)</li> <!-- what is offerer willing to accept in return? -->
		</ul>
		<h2>Message (Weak Entity)</h2>
		<ul>
			<li><strong>messageId (int)</strong></li>
			<li><em>messageSenderProfileId (int)</em></li>
			<li><em>messageReceiverProfileId (int)</em></li>
			<li><em>messagePostId (int, nullable)</em></li>
			<li>messageBrowser (varchar)</li>
			<li>messageContent (varchar)</li>
			<li>messageIpAddress (varbinary 16)</li>
			<li>messageStatus (int)</li>
			<li>messageTimestamp (datetime)</li>
		</ul>
		<h2>Image</h2>
		<ul>
			<li><strong>imageId (int)</strong></li>
			<li><em>imagePostId (int)</em></li>
			<li>imageCloudinaryId (int, from API)</li>
		</ul>
		<h2>Mode (enumeration entity)</h2>
		<ul>
			<li><strong>modeId</strong></li>
			<li>modeName</li>
		</ul>
		<h2>Relations</h2>
		<ul>
			<li>One feed can have many posts (1-to-n)</li>
			<li>Many profiles can have many posts (m-to-n)</li>
			<li>One mode can be used in many posts (1-to-n)</li>
		</ul>
		<h2>APIs Used</h2>
		<ul>
			<li>Cloudinary for image handling</li>
			<li>Google Maps for geolocation</li>
			<li>Pusher for messaging</li>
		</ul>
		<img src="/images/sprout-swap-erd.svg" alt="ERD" />
	</body>
</html>