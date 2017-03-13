<div class="col-md-6 col-xs-12" id="profile">
	<div class="row">
		<div id="img-wrap">
			<img id="profile-img" src="../../images/farmer.jpg">
		</div>
		<!--edit button is hidden unless user is signed-in and viewing their own profile-->
			<a routerLink="edit-profile/:id" class="btn btn-default">Edit Profile</a>
	</div>
	<div class="row">
		<div id="profile-left">
			<p id="profile-handle">Handle: {{ profile.profileHandle }}</p>
			<p id="profile-name">Name: {{ profile.profileName }}</p>
			<p id="profile-email">Email: {{ profile.profileEmail }}</p>
		</div>
		<div id="profile-right">
			<p id="summary-text">More Info: {{ profile.profileSummary }}</p>
		</div>
	</div>
</div>