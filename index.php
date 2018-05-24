<?php
	require 'controller/home.php';

	$link = mysqli_connect("localhost","root","") or die ("Connection lost");
	mysqli_set_charset($link,'utf8');
	mysqli_select_db($link, "Translation_Project");
		
	$languageDao = new LanguageDao($link);		
	$controller = new HomeController($languageDao);
	$controller->process();

	
?>
