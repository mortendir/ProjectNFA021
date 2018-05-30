<?php
	require_once 'controller/home.php';
	require_once 'controller/translation.php';

	$link = mysqli_connect("localhost","root","") or die ("Connection lost");
	mysqli_set_charset($link,'utf8');
	mysqli_select_db($link, "Translation_Project");
	$languageDao = new LanguageDao($link);	

	if (isset($_POST["submit"])) {
		$controller = new TranslationController($languageDao);
		$controller->processSubmit();
	} else {
		$controller = new HomeController($languageDao);
		$controller->process();
	}
	
?>
