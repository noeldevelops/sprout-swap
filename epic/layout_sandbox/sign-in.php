<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<!-- Latest compiled and minified CSS for Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
				integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

		<!-- Latest compiled and minified JavaScript for Bootstrap -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
				  integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
				  crossorigin="anonymous"></script>


		<!--Custom CSS -->
		<link rel="stylesheet" href="../../style/public-style.css">

		<meta charset="utf-8">
		<title>Sprout-Swap</title>
	</head>

	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#signin-modal">Sign In</button>

	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
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
				<form #signin-form="ngForm" name="signin-form" id="signin-form"
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
</html>