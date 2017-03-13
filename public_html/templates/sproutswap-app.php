<div class="sfooter-content">
	<!--our header with logo and main nav, which appears on every page-->
	<header>
		<div class="container-fluid">
			<div class="row"><!--this contains our header/logo and navbar-->
				<div class="col-md-12" id="header-logo">
					<img class="img-responsive" id="logo" src="../images/sprout-swap-logo.png" alt="logo">
				</div>
			</div>
			<div class="row">
				<div class="col-md-12" id="header-nav">
					<ul class="nav navbar-nav navbar-left">
						<li class="navigation"><a routerLink="">Home</a></li>
						<li class="navigation"><signup-component></signup-component></li>
						<li class="navigation"><signin-component></signin-component></li>
						<li><a routerLink="/profile">Profile</a></li>
						<li class="navigation"><newPost></newPost></li>
					</ul>
<!--					<form class="navbar-form navbar-right" id="search" name="search"><input label="search" placeholder="Search" id="search-input" type="text" />-->
<!--					</form>-->
				</div>
			</div>
		</div>
	</header>

	<router-outlet></router-outlet>
</div>

<!-- our footer, which appears on every page -->
<footer>
	<div class="col-md-12">
		<p>Copyright Sprout Swap 2017</p>
		<ul>
			<li>Contact</li>
			<li>Jobs</li>
			<li>About</li>
		</ul>
	</div>
</footer>
