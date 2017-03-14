<!--the main view of a single post (it will populate the post feed)-->
<div class="row main">
	<div class="col-md-6 display">
		<div class="row post">
			<div class="col-md-3">
				<img src="http://res.cloudinary.com/sprout-swap/image/upload/qo5f0afseagr8wb6h6bz.jpg" id="profile-img"/>
				<p id="handle">{{ post.postProfileId }}</p>
			</div>
			<div class="col-md-9">
				<img src="http://res.cloudinary.com/sprout-swap/image/upload/zzd2nbljov2uh4pibeqe.jpg" alt="" id="post-img"/>
				<p class="post-rundown">{{ post.postOffer }}</p>
				<p class="post-rundown">{{ post.postModeId }}</p>
				<p class="post-rundown">{{ post.postRequest }}</p>
				<p class="post-rundown">{{ post.postContent}}</p>
			</div>
		</div>
	</div>
</div>