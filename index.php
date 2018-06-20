<?php
	require_once 'view/error.php';
	require_once 'controller/translation.php';
	require_once 'controller/account.php';

	session_start();

	$link = mysqli_connect("localhost","root","") or die ("Connection lost");
	mysqli_set_charset($link,'utf8');
	mysqli_select_db($link, "Translation_Project");
	$languageDao = new LanguageDao($link);	
	$translationDao = new TranslationDao($link);
	$accountDao = new AccountDao($link);


	if(isset($_POST['action'])) {
		$action = $_POST['action'];
	} else if(isset($_GET['action'])) {
		$action = $_GET['action'];
	} else {
		$action = 'translate';
	}

	
	switch ($action) {
		case 'translate':	
			$controller = new TranslationController($languageDao, $translationDao);
			$controller->showSearch();	
		break;

		case 'dotranslate':
			$controller = new TranslationController($languageDao, $translationDao);
			$controller->processSearch();
		break;

		case 'signup':
			$controller = new AccountController($accountDao);
			$controller->showSignup();
		break;

		case 'dosignup':
			$controller = new AccountController($accountDao);
			$controller->processSignup();
		break;		

		case 'login':
			$controller = new AccountController($accountDao);
			$controller->showLogin();
		break;

		case 'dologin':
			$controller = new AccountController($accountDao);
			$controller->processLogin();
		break;

		case 'dologout':
			$controller = new AccountController($accountDao);
			$controller->processLogout();
		break;
		
		case 'docontribute':
			$controller = new TranslationController($languageDao, $translationDao);
			$controller->processContribution();
		break;
		
		default : 
			http_response_code(404);
			$errorView = new ErrorPage();
			$errorView->display();	
	}
	mysqli_close($link);
?>
