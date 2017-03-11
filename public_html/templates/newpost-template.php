<div class="container">
	<div class="col-xs-12 col-md-6" id="new-post-modal">

		<button id="cancel-post">
			<!-- closes form -->
		</button>
		<div class="logo">
			<img src="../../images/sprout-swap-favi.png" alt="Welcome to Sprout-Swap!">
		</div>
		<!--instructions for users -->
		<div id="new-post-text">
			<p>Make a post and start trading!</p>
		</div>

		<!--actual form-->
		<form #newPostForm="ngForm" name="newPostForm" (ngSubmit)="createPost();">
			<!--an image of the produce they are offering-->
			<div class="formgroup">
				<p>Upload an image of your produce</p>
				<input type="file" name="post-image" id="post-image" required [(ngModel)]="post.postImageId" #profileEmail="ngModel">
			</div>
			<!--up to 75 characters; what they're giving away or selling-->
			<div class="formgroup">
				<p>Tell us what you have for offer</p>
				<input type="text" id="post-offer" required [(ngModel)]="post.postOffer" #post-offer="ngModel">
			</div>
			<!--the mode: for free, for sale, or for trade-->
			<div class="formgroup">
				<p>Is your produce free, for sale, or are you looking to trade?</p>
				<select id="post-mode" name="post-mode" required [(ngModel)]="post.postModeId" #post-mode="ngModel">
					<option value="1">Free</option>
					<option value="2">Sell</option>
					<option value="3">Trade</option>
				</select>
			</div>
			<!--what they are looking for: cash or other veggies.  only shows up if selected mode is not 'free' -->
			<div class="formgroup">
				<p>What do you want in return?</p>
				<input type="text" name="post-request" id="post-request" required [(ngModel)]="post.postRequest" #post-request="ngModel">
			</div>
			<!--allows users to write in further details about what they're offering -->
			<div class="formgroup">
				<p>Give more details about your produce!</p>
				<textarea class="form-control" id="post-summary" rows="5" name="post-summary" placeholder="Max 500 characters" required [(ngModel)]="post.postSummary" #post-summary="ngModel">
					</textarea>
			</div>
			<!--submit the information-->
			<input type="submit" name="signup" class="modal-submit" value="signup">
			<div *ngIf="status !== null" class="alert alert-dismissible"
				  [ngClass]="status.type" role="alert">

				{{ status.message }}

		</form>

	</div>
</div>