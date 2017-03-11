<!--the modal that pops up when you click "sign up"-->
<div class="container">
	<div class="col-xs-12 col-md-6" id="signup-modal">

		<button id="cancel">
			<!-- closes form -->
		</button>
		<div class="logo">
			<img src="../../images/sprout-swap-favi.png" alt="Welcome to Sprout-Swap!">
		</div>
		<!--instructions for users -->
		<div id="login-text">
			<p>Please enter your information to sign-up for Sprout-Swap</p>
		</div>

		<!--actual form-->
		<form action="POST" id="signup-form">
			<!--user's email-->
			<div class="formgroup">
				<p>Email:</p>
				<input type="email" id="signup-email">
			</div>
			<!--user enters password-->
			<div class="formgroup">
				<p>Password:</p>
				<input type="password" id="signup-password">
			</div>
			<!--confirm password-->
			<div class="formgroup">
				<p>Confirm Password:</p>
				<input type="password" id="signup-password-confirm">
			</div>
			<!--set a handle-->
			<div class="formgroup">
				<p>Choose a unique username:</p>
				<input type="text" id="signup-handle">
			</div>
			<!--submit the information-->
			<div class="formgroup" id="signin-final-formgroup">
				<button id="submit">Submit</button>
			</div>
		</form>

	</div>
</div>