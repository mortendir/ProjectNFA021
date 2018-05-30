<?php
require_once 'model/language_dao.php';
require_once 'view/home.php';

class TranslationController {
	private $languageDao;

	public function __construct($languageDao) {
		$this->languageDao = $languageDao;
	}

	public function processSubmit() {
		$languages = $this->languageDao->selectLanguages();
		$codeExtractor = function($language) {
			return $language->getCode();
		};
		$languageCodes = array_map($codeExtractor, $languages);
		$errorMessages = $this->verify($languageCodes);

		$homepage = new HomePage($languages);
		$homepage->display($errorMessages);
	}	

	private function verify($languageCodes) {
		$errorMessages = array();

		if (empty($_POST["source_language"])) {
			$errorMessages["source_language"] = "Choose a language";
		} 
		if (empty($_POST["target_language"])) { 
			$errorMessages["target_language"] = "Choose a language";
		}
		if (empty($errorMessages) && $_POST["source_language"] == $_POST["target_language"]) {
			$errorMessages["source_language"] = "Do not choose the same language";
			$errorMessages["target_language"] = "Do not choose the same language";
		}
		if (empty($errorMessages["source_language"]) && !in_array($_POST["source_language"], $languageCodes)) {
			$errorMessages["source_language"] = "Choose a valid language";
		}
		if (empty($errorMessages["target_language"]) && !in_array($_POST["target_language"], $languageCodes)) {
			$errorMessages["target_language"] = "Choose a valid language";
		}
		return $errorMessages;
	}
}
?>