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
		$this->pwd   = password_hash($pwd, PASSWORD_DEFAULT);//Go ahead and hash the password
	}
	//Getters and Setters
	public function setFirst($first) {
		$this->first = $first;
	}
	public function getFirst() {
		return $this->first;
	}
	public function setLast($last) {
		$this->last = $last;
	}
	public function getLast() {
		return $this->last;
	}
	public function setEmail($email) {
		$this->email = $email;
	}
	public function getEmail() {
		return $this->email;
	}
	public function setUid($uid) {
		$this->uid = $uid;
	}
	public function getUid() {
		return $this->uid;
	}
	public function setPwd($pwd) {//Go ahead and hash the pw
		$this->pwd = password_hash($pwd, PASSWORD_DEFAULT);
	}
	public function getPwd() {
		return $this->pwd;
	}

	public function insertNewUser() {/* Inserts a new user into the db.*/
		try {
			$insertSQL  = "INSERT INTO users(user_first, user_last, user_email, user_uid, user_pwd) VALUES(:first, :last, :email, :uid, :pwd);";
			$stmtInsert = $this->connect()->prepare($insertSQL);
			$stmtInsert->execute(['first' => $this->first, 'last' => $this->last, 'email' => $this->email, 'uid' => $this->uid, 'pwd' => $this->pwd]);
		} catch (PDOException $e) {
			echo $e.getMessage();
		}
	}

	public function checkExistingUser() {
		/*Verifying the user doesn't already exist (aka user_uid in the db table.*/
		try {
			$existingUserQuerySQL = "SELECT COUNT(user_uid) FROM users WHERE user_uid = :uid;";
			$stmtQuery            = $this->connect()->prepare($existingUserQuerySQL);
			$stmtQuery->execute(['uid' => $this->uid]);
			$rows = $stmtQuery->fetchColumn();// Better than rowCount()
			if ($rows > 0) {
				return true;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			echo $e.getMessage();
		}

	}

}

/*
$user = new User('josh', 'otwell', 'gm@email.com', 'bigdad', '123');
var_dump($user);

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