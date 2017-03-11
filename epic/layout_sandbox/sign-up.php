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

	<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Sign Up</button>

	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
		  id="signup-modal">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Enter your information to sign-up for Sprout-Swap!</h4>
				</div>

				<!--actual form-->
				<form #signupForm="ngForm" name="signupForm" (ngSubmit)="createProfile();">
					<!--user's email-->
					<div class="formgroup">
						<p class="modal-labels">Email:</p>
						<input type="email" name ="email" class="modal-inputs" required [(ngModel)]="profile.profileEmail" #profileEmail="ngModel">
					</div>
					<!--user enters password-->
					<div class="formgroup">
						<p class="modal-labels">Password:</p>
						<input type="password" name="password" class="modal-inputs" required [(ngModel)]="profile.profilePassword" #profilePassword="ngModel">
					</div>
					<!--confirm password-->
					<div class="formgroup">
						<p class="modal-labels">Confirm Password:</p>
						<input type="password" name="confirmPassword" class="modal-inputs" required [(ngModel)]="profile.profileConfirmPassword" #profileConfirmPassword="ngModel">
					</div>
					<!--set a handle-->
					<div class="formgroup">
						<p class="modal-labels">Choose a unique username:</p>
						<input type="text" name="handle" class="modal-inputs" required [(ngModel)]="profile.profileHandle" #profileHandle="ngModel">
					</div>
					<!--submit the information-->
					<input type="submit" name="signup" class="modal-submit" value="signup">
					<div *ngIf="status !== null" class="alert alert-dismissible"
						  [ngClass]="status.type" role="alert">

						{{ status.message }}

				</form>
			</div>
		</div>
</html>