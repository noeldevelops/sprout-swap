
<div *ngIf="modes.length > 0">
	<div class="row main" *ngFor="let post of posts">
		<div class="col-xs-12 col-md-6 col-md-offset-3 display">
			<div class="row post">
				<div class="col-md-3">
					<img [src]="profileImageUrl" id="profile-img"/>
					<p id="handle">{{ post.postProfileId }}</p>
				</div>
				<div class="col-md-9">
					<img [src]="imageMap[post.postId]?.imageCloudinaryId" alt="post image" id="post-img"/>
					<p class="post-rundown">{{ post.postOffer }}</p>
					<p class="post-rundown">{{ getModeNameFromArray(post.postModeId) }}</p>
					<p class="post-rundown">{{ post.postRequest }}</p>
					<p class="post-rundown">{{ post.postContent}}</p>
				</div>
			</div>
		</div>
	</div>
</div>