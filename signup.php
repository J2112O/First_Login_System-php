<?php
include_once 'header.php'//Including the header file.
?>
<section class="main-container">
	<div class="main-wrapper">
		<h2>Signup</h2>
		<form class="signup-form" action="includes/signup.inc.php" method="POST">
			<input type="text" name="first" placeholder="First name">
			<input type="text" name="last" placeholder="Last name">
			<input type="email" name="email" placeholder="Email">
			<input type="text" name="uid" placeholder="User name">
			<input type="password" name="pwd" placeholder="Password">
			<button type="submit" name="submit">Sign Up</button>
		</form>
	</div>
</section>

<?php
include_once 'footer.php'//Including the footer file.
?>