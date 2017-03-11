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

	<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Sign In</button>

	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Send a message!</h4>
				</div>

				<!--actual form-->
				<form action="POST" id="message-form">
					<!-- shows users who they're sending to NOTE: message receiver cannot be filled in by user they must get to this page by slicking on a button from either a post or a profile page; this will auto-populate the receiver field -->
					<div class="formgroup">
						<p class="modal-labels">{{messageSender}} to {{messageReceiver}}</p>
					</div>
					<!--actual message-->
					<div class="formgroup">
					<textarea class="form-control modal-inputs" id="message-content" rows="5" name="message-content"
								 placeholder="Enter your message here (Max 500 characters)">
					</textarea>
					</div>
					<!--submit the information-->
					<div class="formgroup" id="signin-final-formgroup">
						<button class="modal-submit">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</html>