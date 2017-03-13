<!--the main view of a single post (it will populate the post feed)-->
<div class="row main">
	<div class="col-md-6 display">
		<div class="row post">
			<div class="col-md-3">
				<img src="../../images/farmer.jpg" id="profile-img"/>
				<p id="handle">{{ post.postProfileId }}</p>
			</div>
			<div class="col-md-9">
				<img src="../../images/zuccs.jpg" alt="" id="post-img"/>
				<p class="post-rundown">{{ post.postOffer }}</p>
				<p class="post-rundown">{{ post.postModeId }}</p>
				<p class="post-rundown">{{ post.postRequest }}</p>
				<p class="post-rundown">{{ post.postContent}}</p>
			</div>
		</div>
	</div>
</div>