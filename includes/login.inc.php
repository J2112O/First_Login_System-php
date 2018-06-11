<?php

session_start();//Must start the session due to using global var below

if (isset($_POST['submit'])) {
	include 'dbh.inc.php';

	$uid = mysqli_real_escape_string($conn, $_POST['uid']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

	//Error handlers
	//Check if inputs are empty
	if (empty($uid) || empty($pwd)) {
		header("Location: ../index.php?login=empty");/* Sending them back*/
		exit();
	} else {
		$sql         = "SELECT * FROM users WHERE user_uid = '$uid' OR user_email = '$uid';";
		$result      = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);// Any rows returned?
		if ($resultCheck < 1) {
			header("Location: ../index.php?login=error");/* Sending them back*/
			exit();
		} else {
			if ($row = mysqli_fetch_assoc($result)) {
				//De-hashing password
				$hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
				if ($hashedPwdCheck == false) {
					header("Location: ../index.php?login=error");/* Sending them back*/
					exit();
				} elseif ($hashedPwdCheck == true) {/* Still must make sure it's true */
					// Log in the user here by setting the $_SESSION global
					$_SESSION['u_id']    = $row['user_id'];
					$_SESSION['u_first'] = $row['user_first'];
					$_SESSION['u_last']  = $row['user_last'];
					$_SESSION['u_email'] = $row['user_email'];
					$_SESSION['u_uid']   = $row['user_uid'];
					header("Location: ../index.php?login=sucess");
					exit();
				}
			}
		}
	}

} else {
	header("Location: ../index.php?login=error");
	exit();
}

?>