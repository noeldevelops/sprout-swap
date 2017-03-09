<!--this is the modal that shows when someone clicks "sign in"-->

<div class="container">
	<div class="col-xs-12 col-md-6" id="login-modal">

		<button id="cancel">
			<!-- closes form -->
		</button>
		<div class="logo">
			<img src="../../images/sprout-swap-favi.png" alt="Welcome to Sprout-Swap!">
		</div>
		<!--instructions for users -->
		<div id="login-text">
			<p>Please enter your email and password to log-in</p>
		</div>
		<!--actual form-->
		<form action="POST" id="login-form">
			<!--user's email-->
			<div class="formgroup">
				<p>Email:</p>
				<input type="email" id="signin-email">
			</div>
			<!--up to 75 characters; what they're giving away or selling-->
			<div class="formgroup">
				<p>Password:</p>
				<input type="password" id="login-password">
			</div>
			<!--submit the information-->
			<div class="formgroup" id="sign-in-final-formgroup">
				<button id="submit">Submit</button>
			</div>
		</form>

	</div>
</div>