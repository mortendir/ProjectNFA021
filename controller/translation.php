<?php
require_once 'model/language_dao.php';
require_once 'model/translation_dao.php';
require_once 'view/home.php';

class TranslationController {
	private $languageDao;
	private $translationDao;

	public function __construct($languageDao, $translationDao) {
		$this->languageDao = $languageDao;
		$this->translationDao = $translationDao;
	}

	public function processSubmit() {
		$languages = $this->languageDao->selectLanguages();
		$codeExtractor = function($language) {
			return $language->getCode();
		};
		$languageCodes = array_map($codeExtractor, $languages);
		$errorMessages = $this->verify($languageCodes);

		$homepage = new HomePage($languages);
		$targetPhrases = $this->translationDao->selectTranslations($_POST["source_phrase"], $_POST["source_language"], $_POST["target_language"]);
		$homepage->display($errorMessages, $_POST, $targetPhrases);
	}	

	private function verify($languageCodes) {
		$errorMessages = array();

		if (empty($_POST["source_language"])) {
			$errorMessages["source_language"] = "Please choose a language";
		} 
		if (empty($_POST["target_language"])) { 
			$errorMessages["target_language"] = "Please choose a language";
		}
		if (empty($errorMessages) && $_POST["source_language"] == $_POST["target_language"]) {
			$errorMessages["source_language"] = "Please do not choose the same language";
			$errorMessages["target_language"] = "Please do not choose the same language";
		}
		if (empty($errorMessages["source_language"]) && !in_array($_POST["source_language"], $languageCodes)) {
			$errorMessages["source_language"] = "Please choose a valid language";
		}
		if (empty($errorMessages["target_language"]) && !in_array($_POST["target_language"], $languageCodes)) {
			$errorMessages["target_language"] = "Please choose a valid language";
		}
		if (empty($_POST["source_phrase"])) {
			$errorMessages["source_phrase"] = "Please write a phrase";
		}
		return $errorMessages;
	}
	
}
?>