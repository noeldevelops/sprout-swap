<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<!-- Latest compiled and minified CSS for Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
				integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!--Custom CSS -->
		<link rel="stylesheet" href="../../style/public-style.css">
		<!-- Latest compiled and minified JavaScript for Bootstrap -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
				  integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
				  crossorigin="anonymous"></script>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

		<meta charset="utf-8">
		<title>Sprout-Swap</title>
	</head>

	<div class="container">
		<div class="col-xs-12 col-md-6" id="new-message-modal">

			<button id="cancel">
				<!-- closes form -->
			</button>

			<!--instructions for users -->
			<div id="new-message-text">
				<p>Enter your message below</p>
			</div>
			<!--actual form-->
			<form action="POST" id="new-message-form">
				<!--an image of the produce they are offering-->
				<div class="formgroup">
					<p>{{messageSender}} to {{messageReceiver}}</p>
				</div>
				<!--allows users to write in further details about what they're offering -->
				<div class="formgroup">
					<textarea class="form-control" id="message-content" rows="5" name="message-content" placeholder="Enter your message here (Max 500 characters)">
					</textarea>
				</div>
				<!--submit the information-->
				<div class="formgroup" id="new-message-final-formgroup">
					<button id="submit">Submit</button>
				</div>
			</form>

		</div>
	</div>
</html>
