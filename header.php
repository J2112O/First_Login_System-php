<?php
session_start();
?>
<!--  header -->
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header>
	<nav>
		<div class="main-wrapper">
			<ul>
			    <li><a href="index.php">Home</a></li>
			</ul>
		</div>
		<div class="nav-login">
<?php
if (isset($_SESSION['u_id'])) {/*If user is logged in, this 'Logout' button is provided to them due to the global $_SESSION variable is set, hence the user is logged in.*/
	echo '<form action="includes/logout.inc.php" method="POST">
			<button type="submit" name="submit">Logout</button>
		</form>';
} else {/*If the global $_SESSION variable is not set, the user is not logged in so they are only proveded and shown the Login button here. */
	echo '<form action="includes/login.inc.php" method="POST">
				<input type="text" name="uid" placeholder="Username/e-mail">
				<input type="password" name="pwd" placeholder="password">
				<button type="submit" name="submit">Login</button>
		</form>
		<a href="signup.php">Sign up</a>';
}
?>
		</div>

	</nav>
</header><!-- /header -->