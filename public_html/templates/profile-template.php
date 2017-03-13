<div class="col-md-6 col-xs-12" id="profile">
	<div class="row">
		<div id="img-wrap">
			<img id="profile-img" src="../../images/farmer.jpg">
		</div>
		<div *ngIf="profile.profileId === <?php $_SESSION['profile']->getProfileId() ?>">
			<button id="edit">Edit Profile</button>
		</div>
	</div>
	<div class="row">
		<div id="profile-left">
			<!--edit button is hidden unless user is signed-in and viewing their own profile-->
			<p id="profile-handle">{{ profile.profileHandle }}: JoeGrows</p>
			<p id="profile-name">{{ profile.profileName }}: Joe Mama</p>
			<p id="profile-email">{{ profile.profileEmail }}: somethign@email.com</p>
		</div>
		<div id="profile-right">
			<p id="summary-text">{{ profile.profileSummary }}: This is my profile. I like to grow things. I like to
				trade
				the things
				that I grow. I am from Albuquerque, NM and have three dogs, two cats, a horse, a cow, and
				some sheep.</p>
		</div>
	</div>
	<!--	<div id="profile-post-view">-->
	<!--		<!-- will show all posts from a user or placeholder if they have made none-->-->
	<!--	</div>-->
</div>