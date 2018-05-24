<?php
$sourceErr = $targetErr ="";
$sourceLanguage = $targetLanguage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ((empty($_POST["source_language"]) || empty($_POST["target_language"])) {
    	$sourceErr = "Language is required";
    	$targetErr = "Language is required";
    } else

?>