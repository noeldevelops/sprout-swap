<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<!-- Latest compiled and minified CSS for Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
				integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript for Bootstrap -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
				  integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
				  crossorigin="anonymous"></script>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

		<meta charset="utf-8">
		<title>Sprout-Swap</title>
	</head>
	<body>
		<div id="signup-modal">
			<div id="logo">
				<!--insert logo here-->
			</div>
			<div id="signup-text">
				<p>Sign up for Sprout Swap and start trading veggies today!</p>
			</div>
			<form action="POST">
				<input type="text" id="name">
				<input type="text" id="handle">
				<input type="email" class="email">
				<input type="text" id="password">
				<input type="text" id="confirm-pass">
				<button id="submit">Sign Up!</button>
			</form>
			<!--hidden div that shows after valid form submitted-->
			<div id="activate">
				<p>Almost done! check your email to confirm. Please allow ample time for the email to arrive.</p>
			</div>
			
		</div>

	</body>
</html>