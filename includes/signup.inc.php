<?php

if (isset($_POST['submit'])) {// Verifies user clicked sign up button
	include_once 'dbh.inc.php';
	include 'user.inc.php';

	$first = $_POST['first'];
	$last  = $_POST['last'];
	$email = $_POST['email'];
	$uid   = $_POST['uid'];
	$pwd   = $_POST['pwd'];

	$user = new User($first, $last, $email, $uid, $pwd);

	/*
	//From original site
	$first = mysqli_real_escape_string($conn, $_POST['first']);
	$last  = mysqli_real_escape_string($conn, $_POST['last']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$uid   = mysqli_real_escape_string($conn, $_POST['uid']);
	$pwd   = mysqli_real_escape_string($conn, $_POST['pwd']);
	 */

	// Error handlers
	// Check for empty fields
	if (empty($user->getFirst()) || empty($user->getLast()) || empty($user->getEmail()) || empty($user->getUid()) || empty($user->getPwd())) {
		header("Location: ../signup.php?signup=empty");/* If fields are empty  sending them back and exiting before even making it to else block..*/
		exit();
	} else {
		//Check if input characters are valid
		if (!preg_match("/^[a-zA-Z]*$/", $user->getFirst()) || !preg_match("/^[a-zA-Z]*$/", $user->getLast())) {
			header("Location: ../signup.php?signup=invalid");/* If invalid characters are found sending them back to sign up.*/
			exit();
		} else {
			//Check if email is valid
			if (!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
				header("Location: ../signup.php?signup=email");/* If invalid email, sending them back to sign up.*/
				exit();
			} else {/* Checking if that user name (user_uid) already exists also making sure it is not 'root' */
				/*
				$sql         = "SELECT user_uid FROM users WHERE user_uid = '$uid' OR user_uid = 'root';";
				$result      = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);// Any rows returned?*/
				$resultCheck = $user->checkExistingUser();
				if ($resultCheck == true) {
					header("Location: ../signup.php?signup=usertaken");/* Username taken or 'root', sending them back to sign up.*/
					exit();
				} else {
					/*
					//Hashing the password
					$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
					//Insert the user into the database
					$sql = "INSERT INTO users(user_first, user_last, user_email, user_uid, user_pwd) VALUES ('$first', '$last', '$email', '$uid', '$hashedPwd');";
					mysqli_query($conn, $sql);//running the code
					 */
					//'root' is not allowed for uid (aka user_uid)
					if ($user->getUid() == 'root') {
						header("Location: ../signup.php?signup=usernamenotallowed");/* Username 'root', sending them back .*/
						exit();
					} else {
						$user->insertNewUser();//Calling class method to insert
						header("Location: ../signup.php?signup=success");/* user inserted.*/
						exit();
					}

				}
			}
		}

	}
} else {
	header("Location: ../signup.php");/* If button wasn't clicked, sending them right back to the Sign up page. This twarts just entering the url.*/
	exit();
}

?>