<div class="col-xs-12 col-md-6" id="new-post-modal">

	<div id="logo">
		<!--insert logo here-->
	</div>
	<!--instructions for users -->
	<div id="new-post-text">
		<p>Enter the following information to post your produce!</p>
	</div>
	<button id="cancel-post">
		<!-- closes form -->
	</button>
	<!--actual form-->
	<form action="POST">
		<!--an image of the produce they are offering-->
		<input type="file" id="post-image" value="image">
		<!--up to 75 characters; what they're giving away or selling-->
		<input type="text" id="post-offer">
		<!--the mode: for free, for sale, or for trade-->
		<select name="post-mode">
			<option value="free">Free</option>
			<option value="sell">Sell</option>
			<option value="trade">Trade</option>
		</select>
		<!--what they are looking for: cash or other veggies.  only shows up if mode is not 'free' -->
		<input type="text" id="post-request">
		<!--allows users to write in further details about what they're offering -->
		<input type="text" id="post-summary">
		<!--submit the information-->
		<button id="submit">Submit</button>
	</form>

</div>