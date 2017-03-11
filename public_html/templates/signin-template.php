<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#signin-modal">Sign In</button>

<div class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Enter your email and password to login</h4>
			</div>
			<div class="logo">
				<img src="../../images/sprout-swap-favi.png" alt="Welcome to Sprout-Swap!">
			</div>

			<!--actual form-->
			<form #signInForm="ngForm" name="signInForm" id="signInForm"
					(ngSubmit)="signIn();">
				<!--user's email-->
				<div class="formgroup">
					<label for="signin-email" class="modal-labels">Email:</label>
					<input type="email" name="signin-email" id="signin-email" required [(ngModel)]="signin.profileEmail" #profileEmail="ngModel" class="modal-inputs">
				</div>
				<!--user's password-->
				<div class="formgroup">
					<label for="signin-password" class="modal-labels">Password:</label>
					<input type="password" id="signin-password" name="signin-password" required [(ngModel)]="signin.profilePassword" #profilePassword="ngModel" class="modal-inputs">
				</div>
				<!--submit the information-->
				<div class="formgroup" id="signin-final-formgroup">
					<button type="submit" id="submit" [disabled]="signin-form.invalid" class="modal-submit">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>