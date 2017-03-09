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
		<div class="col-xs-12 col-md-6" id="new-post-modal">

			<button id="cancel-post">
				<!-- closes form -->
			</button>
			<div id="logo">
				<img src="../../images/sprout-swap-favi.png" alt="Welcome to Sprout-Swap!">
			</div>
			<!--instructions for users -->
			<div id="new-post-text">
				<p>Make a post and start trading!</p>
			</div>
			<!--actual form-->
			<form action="POST" id="new-post-form">
				<!--an image of the produce they are offering-->
				<div class="formgroup">
					<p>Upload an image of your produce</p>
					<input type="file" id="post-image">
				</div>
				<!--up to 75 characters; what they're giving away or selling-->
				<div class="formgroup">
					<p>Tell us what you have for offer</p>
					<input type="text" id="post-offer">
				</div>
				<!--the mode: for free, for sale, or for trade-->
				<div class="formgroup">
					<p>Is your produce free, for sale, or are you looking to trade?</p>
					<select name="post-mode">
						<option value="free">Free</option>
						<option value="sell">Sell</option>
						<option value="trade">Trade</option>
					</select>
				</div>
				<!--what they are looking for: cash or other veggies.  only shows up if selected mode is not 'free' -->
				<div class="formgroup">
					<p>What do you want in return?</p>
					<input type="text" id="post-request">
				</div>
				<!--allows users to write in further details about what they're offering -->
				<div class="formgroup">
					<p>Give more details about your produce!</p>
					<textarea class="form-control" id="post-summary" rows="5" name="post-summary" placeholder="Max 500 characters">
					</textarea>
				</div>
				<!--submit the information-->
				<div class="formgroup" id="final-formgroup">
					<button id="submit">Submit</button>
				</div>
			</form>

		</div>
	</div>
</html>
