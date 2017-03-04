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
		<header>
			<div class="container">
				<!--inject our header/logo and navbar-->
			</div>
		</header>
		<main>
			<div class="container">
				<!--inject sidebar navigation (changes depending on if user is logged in)-->

				<!--main center div-->
				<div class="col-md-6" id="main-body">
					<!--profile view-->
					<div class="profile">
						<div class="row">
							<div class="col-md-2">
								<img id="profile-img">
								<!--edit button is hidden unless user is signed-in and viewing their own profile-->
								<button id="edit"></button>
								<p id="handle"></p>
								<p id="name"></p>
								<p id="email"></p>
							</div>
							<div class="col-md-4" id="summary">
								<p class="summary-text"></p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6" id="profile-history">
								<!-- inject posts from this user, with edit buttons if user is logged in like above -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>

	</body>
</html>