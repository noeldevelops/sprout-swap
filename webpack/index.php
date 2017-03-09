<?php
require_once(dirname(__DIR__) . "/php/lib/xsrf.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
setXsrfCookie();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<base href="<?php echo dirname($_SERVER["PHP_SELF"]) . "/"; ?>" />

		<title>Sprout-Swap</title>
	</head>

	<body class="sfooter">
		<sproutswap-app>Loading&hellip;</sproutswap-app>
	</body>
</html>