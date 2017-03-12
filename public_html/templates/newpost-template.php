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
				<input type="file" name="postImage" id="postImage" required [(ngModel)]="post.postImageId" #profileEmail="ngModel">
			</div>
			<!--up to 75 characters; what they're giving away or selling-->
			<div class="formgroup">
				<p>Tell us what you have for offer</p>
				<input type="text" id="postOffer" required [(ngModel)]="post.postOffer" #postOffer="ngModel">
			</div>
			<!--the mode: for free, for sale, or for trade-->
			<div class="formgroup">
				<p>Is your produce free, for sale, or are you looking to trade?</p>
				<select id="postMode" name="postMode" required [(ngModel)]="post.postModeId" #postMode="ngModel">
					<option value="1">Free</option>
					<option value="2">Sell</option>
					<option value="3">Trade</option>
				</select>
			</div>
			<!--what they are looking for: cash or other veggies.  only shows up if selected mode is not 'free' -->
			<div class="formgroup">
				<p>What do you want in return?</p>
				<input type="text" name="postRequest" id="postRequest" required [(ngModel)]="post.postRequest" #postRequest="ngModel">
			</div>
			<!--allows users to write in further details about what they're offering -->
			<div class="formgroup">
				<p>Give more details about your produce!</p>
				<textarea class="form-control" id="postSummary" rows="5" name="postSummary" placeholder="Max 500 characters" required [(ngModel)]="post.postSummary" #postSummary="ngModel">
					</textarea>
			</div>
			<!--submit the information-->
			<input type="submit" name="signup" class="modal-submit" value="signup">
		</form>
	</div>
</div>