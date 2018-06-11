<?php
if (isset($_POST['submit'])) {
	session_start();// Session has to be started in order to kill it lol.
	session_unset();//Unsetting the session.
	session_destroy();//Destroying the session.
	header("Location: ../index.php");//Back to main page.
	exit();
}

?>