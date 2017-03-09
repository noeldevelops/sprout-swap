<!--this is the header and main page navigation-->
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<!-- Latest compiled and minified CSS for Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
				integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<!-- Our custom CSS -->
		<link rel="stylesheet" href="../../style/public-style.css"/>
		<!-- Latest compiled and minified JavaScript for Bootstrap -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
				  integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
				  crossorigin="anonymous"></script>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://code.jquery.com/jquery-3.1.1.min.js"
				  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
				  crossorigin="anonymous"></script>

		<meta charset="utf-8">
		<title>Sprout-Swap</title>
	</head>
	<body>
		<header>
			<div class="container-fluid">
				<div class="row"><!--this contains our header/logo and navbar-->
					<div class="col-md-12" id="header-logo">
						<img class="img-responsive" id="logo" src="../../images/sprout-swap-logo.png" alt="logo">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" id="header-nav">
						<ul class="nav navbar-nav navbar-left">
							<li class="navigation"><a href="#">Home</a></li>
							<li class="navigation"><a href="#">Sign In/Sign Up</a></li>
						</ul>
						<!--						<li class="navigation"><a></a></li>-->
						<form class="navbar-form navbar-right" id="search" name="search"><input label="search" placeholder="Search" id="search-input" type="text" />
						</form>
					</div>
				</div>
			</div>
		</header>
		<div class="container-fluid">
			<div class="row main">
				<div class="col-md-3"></div>
				<div class="col-md-6 display">
					<div class="row post">
						<div class="col-md-3">
							<img src="../../images/farmer.jpg" id="profile-img">
							<p id="handle">JoeGrows</p>
						</div>
						<div class="col-md-9">
							<img src="../../images/zuccs.jpg" alt="" id="post-img">
							<p id="post-rundown">Please buy my extra zucchini!!!</p>
						</div>
					</div>
					<div class="row post">
						<div class="col-md-3">
							<img src="../../images/FarmerJohn.jpg" id="profile-img">
							<p id="handle">WeFarmIt</p>
						</div>
						<div class="col-md-9">
							<img src="../../images/carrots.jpg" alt="" id="post-img">
							<p id="post-rundown">Anyone want to trade for carrots?</p>
						</div>
					</div>
				</div>
				<div class="col-md-3"></div>
			</div>
		</div>