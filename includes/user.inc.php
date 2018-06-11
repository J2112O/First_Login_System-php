<?php

class User extends Dbh {

	//Class properties
	private $first;
	private $last;
	private $email;
	private $uid;
	private $pwd;

	//Constructor
	public function __construct($first, $last, $email, $uid, $pwd) {
		$this->first = $first;
		$this->last  = $last;
		$this->email = $email;
		$this->uid   = $uid;
		$this->pwd   = $pwd;
	}
	//Getters and Setters
	public function setFirst($newFirst) {
		$this->first = $newFirst;
	}
	public function getFirst() {
		return $this->first;
	}
	public function setLast($newLast) {
		$this->last = $newLast;
	}
	public function getLast() {
		return $this->last;
	}
	public function setEmail($newEmail) {
		$this->email = $newEmail;
	}
	public function getEmail() {
		return $this->email;
	}
	public function setUid($newUid) {
		$this->uid = $newUid;
	}
	public function getUid() {
		return $this->uid;
	}
	public function setPwd($newPwd) {
		$this->pwd = $newPwd;
	}
	public function getPwd() {
		return $this->pwd;
	}

	public function insertNewUser() {
		//Hashing the password
		$hashedPwd = password_hash($this->pwd, PASSWORD_DEFAULT);

		$insertSQL  = "INSERT INTO users(user_first, user_last, user_email, user_uid, user_pwd) VALUES(:first, :last, :email, :uid, :hashedPwd);";
		$stmtInsert = $this->connect()->prepare($insertSQL);
		$stmtInsert->execute(['first' => $this->first, 'last' => $this->last, 'email' => $this->email, 'uid' => $this->uid, 'hashedPwd' => $hashedPwd]);
	}

	public function checkExistingUser() {
		//$uid = $_POST['uid'];
		/*Verifying the user doesn't already exist, nor is entering the 'root' name for a uid.*/
		$existingUserQuerySQL = "SELECT user_uid FROM users WHERE user_uid = :uid OR user_uid = 'root';";
		$stmtQuery            = $this->connect()->prepare($existingUserQuerySQL);
		$stmtQuery->execute(['uid' => $this->uid]);
		return $stmtQuery;
	}

}

/**
 * below is from original oop lesson
 */
/*
class User extends Dbh {

public function getAllUsers() {
$stmt = $this->connect()->query("SELECT * FROM user;");
while ($row = $stmt->fetch()) {
$id = $row['id']."<br>";
//$uid = $row['uid']."<br>";
//$password  = $row['password'];
return $id;
}
}
public function getUsersWithCountCheck() {
$id  = 1;
$uid = 'josh';

$stmt = $this->connect()->prepare("SELECT * FROM user WHERE id=? AND uid=?");
$stmt->execute([$id, $uid]);

if ($stmt->rowCount()) {
while ($row = $stmt->fetch()) {
return $row['uid'];
}
}
}
public function insertNewUser() {
$id       = $_POST['id'];
$uid      = $_POST['uid'];
$password = $_POST['password'];

$stmtInsert = $this->connect()->prepare("INSERT INTO user(id, uid, password) VALUES(?, ?, ?);");
$stmtInsert->execute([$id, $uid, $password]);

should take back to 'front page'
header("Location: ../index.php?signup=succes");
}
}

from first video without pdo, only using mysqli

protected function getAllUsers() {
$sql    = "SELECT * FROM user";
$result = $this->connect()->query($sql);

$numRows = $result->num_rows;
if ($numRows > 0) {
while ($row = $result->fetch_assoc()) {
$data[] = $row;
}
return $data;
}

}

 */
?>