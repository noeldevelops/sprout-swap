<div class="col-md-6 col-xs-12" id="profile">
	<div class="row">
		<div id="img-wrap">
			<img id="profile-img" src="../../images/farmer.jpg">
		</div>
	</div>
	<form #editProfileForm="ngForm" name="editProfileForm" (ngSubmit)="editProfile();">
		<file-upload></file-upload>
		<div class="row">
			<div class="form-group">
				<div id="profile-left">
					<label for="edit-profile-handle">Handle: </label>
					<input type="text" id="edit-profile-handle" placeholder="{{ profile.profileHandle }}" required [(ngModel)]="profile.profileHandle" #profileHandle="ngModel">
					<label for="edit-profile-name">Name: </label>
					<input id="edit-profile-name" placeholder="{{ profile.profileName }}" required
							 [(ngModel)]="profile.profileName" #profileName="ngModel">
					<p id="profile-email">Email: {{ profile.profileEmail }}</p>
				</div>
			</div>
			<div id="profile-right">
				<label for="edit-summary-text">More Info: </label>
				<input id="edit-summary-text" placeholder="{{ profile.profileSummary }}" required
						 [(ngModel)]="profile.profileSummary" #profileSummary="ngModel">
			</div>
		</div>
		<input type="submit" name="editProfile" id="editProfile" class="modal-submit" value="Submit">
	</form>
</div>