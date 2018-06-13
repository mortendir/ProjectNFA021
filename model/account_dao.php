<?php
class AccountDao {
	private $link;

	public function __construct($link) {
		$this->link = $link;
	}

	public function hasAccount($username, $password) {
		$username = mysqli_real_escape_string($this->link, $username);
		$password = mysqli_real_escape_string($this->link, $password);
		$sql = "SELECT * FROM Users WHERE username = '$username' AND password = '$password'";
		$result = mysqli_query($this->link, $sql) or die (mysqli_error($this->link));
		$rows = mysqli_num_rows($result);
		mysqli_free_result($result);
		if($rows == 0) {
			return false;
		} else {
			return true;
		}
	}

	public function hasUsername($username) {
		$username = mysqli_real_escape_string($this->link, $username);
		$sql = "SELECT * FROM Users WHERE username = '$username'";
		$result = mysqli_query($this->link, $sql) or die (mysqli_error($this->link));
		$rows = mysqli_num_rows($result);
		mysqli_free_result($result);
		if($rows == 0) {
			return false;
		} else {
			return true;
		}
	}
	
	public function register($username, $password) {
		$username = mysqli_real_escape_string($this->link, $username);
		$password = mysqli_real_escape_string($this->link, $password);
		$sql = "INSERT INTO Users (`username`, `password`) VALUES ('$username', '$password')";
		mysqli_query($this->link, $sql) or die (mysqli_error($this->link));
	}
}
?>