<?php
include_once ('constants.php');/* $db variables comes from here since this file is hidden from repo in the .gitignore file.*/
// Old $conn below from original shot at this from the actual tutorial
//$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

class Dbh {

	private $servername;
	private $username;
	private $password;
	private $dbname;
	private $charset;

	public function connect() {
		/*Variable here are still assigned from the constants.php file*/
		$this->servername = $dbServername;
		$this->username   = $dbUsername;
		$this->password   = $dbPassword;
		$this->dbname     = $dbName;
		$this->charset    = "utf8mb4";

		try {
			$dsn = "mysql:host=".$this->servername.";dbname=".$this->dbname.";charset=".$this->charset;
			$pdo = new PDO($dsn, $this->username, $this->password);
			/* Setting the default fetch mode to object below along with error messages*/
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			return $pdo;
		} catch (PDOException $e) {
			echo "Connection failed: ".$e->getMessage();
		}

	}

}

?>