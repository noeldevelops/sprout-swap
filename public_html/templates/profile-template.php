<div class="col-md-6 col-xs-12" id="profile">
	<div class="row">
		<div id="img-wrap">
			<img id="profile-img" src="../../images/farmer.jpg">
		</div>
		<!--edit button is hidden unless user is signed-in and viewing their own profile-->
			<button id="edit">Edit Profile</button>
	</div>
	<div class="row">
		<div id="profile-left">
			<p id="profile-handle">{{ profile.profileHandle }}</p>
			<p id="profile-name">{{ profile.profileName }}</p>
			<p id="profile-email">{{ profile.profileEmail }}</p>
		</div>
		<div id="profile-right">
			<p id="summary-text">{{ profile.profileSummary }}</p>
		</div>
	</div>
	<!--	<div id="profile-post-view">-->
	<!--		<!-- will show all posts from a user or placeholder if they have made none-->-->
	<!--	</div>-->
</div>