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
		<div id="new-post-modal">
			<div id="logo">
				<!--insert logo here-->
			</div>
			<div id="new-post-text">
				<p>Enter the following information to post your produce!</p>
			</div>
			<form action="POST">
				<input type="text" id="post-offer">
				<select name="post-mode">
					<option value="free">Free</option>
					<option value="sell">Sell</option>
					<option value="trade">Trade</option>
				</select>
				<input type="text" id="post-request">
				<input type="text" id="post-summary">
				<input type="file" id="post-image">
				<button id="submit">Make a swap!</button>
			</form>

		</div>

	</body>
</html>