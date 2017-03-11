<!--this is the modal that shows when someone clicks "sign in"-->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#signin-modal">Sign In</button>

<div class="container">
	<div class="col-xs-12 col-md-6" id="signin-modal">

		<button id="cancel">
			<!-- closes form -->
		</button>
		<div class="logo">
			<img src="../../images/sprout-swap-favi.png" alt="Welcome to Sprout-Swap!">
		</div>
		<!--instructions for users -->
		<div id="login-text">
			<p>Please enter your email and password to login.</p>
		</div>
		<!--actual form-->
		<form #signin-form="ngForm" name="signin-form" id="signin-form"
				(ngSubmit)="signIn();">
			<!--user's email -->
			<div class="formgroup">
				<label for="signin-email">Email:</label>
				<input type="email" name="signin-email" id="signin-email" required [(ngModel)]="signin.profileEmail" #profileEmail="ngModel">
			</div>
<!--			user's password-->
			<div class="formgroup">
				<label for="signin-password">Password:</label>
				<input type="password" id="signin-password" name="signin-password" required [(ngModel)]="signin.profilePassword" #profilePassword="ngModel">
			</div>
			<!--submit the information-->
			<div class="formgroup" id="signin-final-formgroup">
				<button type="submit" id="submit" [disabled]="signin-form.invalid">Submit</button>
			</div>
		</form>

	</div>
</div>