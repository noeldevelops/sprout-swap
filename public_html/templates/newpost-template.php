<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newPostModel">New Post</button>

<div class="modal fade" tabindex="-1" role="dialog" id="newPostModal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Post your produce!</h4>
			</div>

			<!--begin actual form -->
			<form #newPostForm="ngForm" name="newPostForm" (ngSubmit)="createPost();">
				<!--an image of the produce they are offering-->
				<div class="form-group">
					<label for="postImage">Upload an image</label>
					<input type="file" name="postImage" id="postImage" class="modal-inputs" required
							 [(ngModel)]="post.postImageId" #postImage="ngModel">
				</div>
				<!--up to 75 characters; what they're giving away or selling-->
				<div class="form-group">
					<label for="postOffer">Tell us what you have for offer</label>
					<input type="text" id="postOffer" class="modal-inputs" required [(ngModel)]="post.postOffer"
							 #postOffer="ngModel">
				</div>
				<!--the mode: for free, for sale, or for trade-->
				<div class="form-group">
					<label for="postMode">Is your produce free, for sale, or are you looking to trade?</label>
					<select id="postMode" name="postMode" class="modal-inputs" required [(ngModel)]="post.postModeId"
							  #postMode="ngModel">
						<option value="1">Free</option>
						<option value="2">Sell</option>
						<option value="3">Trade</option>
					</select>
				</div>
				<!--what they are looking for: cash or other veggies.  only shows up if selected mode is not 'free' -->
				<div class="form-group">
					<label for="postRequest"> What do you want in return?</label>
					<input type="text" name="postRequest" id="postRequest" class="modal-inputs" required
							 [(ngModel)]="post.postRequest" #postRequest="ngModel">
				</div>
				<!--allows users to write in further details about what they're offering -->
				<div class="form-group">
					<label for="postSummary">Give more details about your produce!</label>
					<textarea class="form-control modal-inputs" id="postSummary" rows="5" name="postSummary"
								 placeholder="Max 500 characters" required [(ngModel)]="post.postSummary"
								 #postSummary="ngModel"></textarea>
				</div>
				<!--submit the information-->
				<input type="submit" name="newPost" id="newPost" class="modal-submit" value="Submit">
				<!--<div>{{status.message}}</div>-->
			</form>
		</div>
	</div>
</div>