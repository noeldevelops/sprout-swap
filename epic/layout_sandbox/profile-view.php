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
	<body>
		<header id="nav">
			<!--inject header-nav.php here-->
		</header>
		<main>
			<div class="container">
				<!--inject sidebar navigation here-->

				<!--this is the main center div-->
				<!--profile view-->
				<div class="col-md-6" id="profile">
					<div id="img-wrap">
						<img id="profile-img" src="../../images/farmer.jpg">
						<button id="edit">Edit Profile</button>
					</div>
					<div id="profile-left">
						<!--edit button is hidden unless user is signed-in and viewing their own profile-->
						<p id="profile-handle">{{profile-handle}}: JoeGrows</p>
						<p id="profile-name">{{profile-name}}: Joe Mama</p>
						<p id="profile-email">{{profile-email}}: somethign@email.com</p>
					</div>
					<div id="profile-right">
						<p id="summary-text">{{profile-summary}}: This is my profile. I like to grow things. I like to trade
							the things
							that I grow. I am from Albuquerque, NM and have three dogs, two cats, a horse, a cow, and
							some sheep.</p>
					</div>
				</div>
				<div id="profile-post-view">
					<!-- will show all posts from a user or placeholder if they have made none-->
				</div>
			</div>
		</main>

	</body>
</html>