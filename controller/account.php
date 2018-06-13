<?php
require_once 'model/account_dao.php';
require_once 'view/login.php';
require_once 'view/signup.php';

class AccountController {
	private $accountDao;

	public function __construct($accountDao) {
		$this->accountDao = $accountDao;
	}

	public function processLogin() {
		$errorMessages = $this->verifyUserInformation();
		if (!empty($errorMessages)) {
			$loginPage = new LoginPage();
			$loginPage->display(false, $errorMessages, $_POST);
			return;
		}
		$hasAccount = $this->accountDao->hasAccount($_POST["username"], $_POST["password"]);
		if (!$hasAccount) {
			$loginPage = new LoginPage();
			$errorMessages = array('username' => 'Account not found', 'password' => 'Account not found');
			$loginPage->display(false, $errorMessages, $_POST);
			return;
		} 
		$_SESSION['user'] = $_POST["username"];
		header('Location: index.php');
	}

	public function processSignup() {
		$errorMessages = $this->verifyUserInformation();
		if (!empty($errorMessages)) {
			$signupPage = new SignupPage();
			$signupPage->display($errorMessages, $_POST);
			return;
		}
		$hasUsername = $this->accountDao->hasUsername($_POST["username"]);
		if ($hasUsername) {
			$signupPage = new SignupPage();
			$signupPage->display(array('username' => 'Username already exists'), $_POST);
			return;
		}
		$this->accountDao->register($_POST["username"], $_POST["password"]);
		header('Location: index.php?action=login&registrationSuccess');
	}

	public function processLogout() {
		unset($_SESSION['user']);
		session_destroy();
	 	header('Location: index.php');
	}

	public function showSignup() {
		$signupPage = new SignupPage();
		$signupPage->display();
	}

	public function showLogin() {
		$loginPage = new LoginPage();
		$loginPage->display(isset($_GET['registrationSuccess']));
	}

	private function verifyUserInformation() {
		$errorMessages = array();

		if (empty($_POST["username"])) {
			$errorMessages["username"] = "Please specify a username";
		} 
		if (empty($_POST["password"])) { 
			$errorMessages["password"] = "Please specify a password";
		}
		if (strlen($_POST["username"]) > 100) {
			$errorMessages["username"] = "Username must be under 100 characters";
		}
		if (strlen($_POST["password"]) > 100) {
			$errorMessages["password"] = "Password must be under 100 characters";
		}	
		return $errorMessages;
	}
}

?>
