<?php
require_once 'model/language_dao.php';
require_once 'model/translation_dao.php';
require_once 'view/home.php';

class TranslationController {
	private $languageDao;
	private $translationDao;
	private $codeExtractor;

	public function __construct($languageDao, $translationDao) {
		$this->languageDao = $languageDao;
		$this->translationDao = $translationDao;
		$this->codeExtractor = function($language) {
			return $language->getCode();
		};
	}

	public function processSearch() {
		$languages = $this->languageDao->selectLanguages();
		$languageCodes = array_map($this->codeExtractor, $languages);
		$errorMessages = $this->verifySearch($languageCodes);

		$homepage = new HomePage($languages);
		$translations = $this->translationDao->selectTranslations($_POST["source_phrase"], $_POST["source_language"], $_POST["target_language"]);
		$homepage->display(false, $errorMessages, $_POST, $translations);
	}

	public function showSearch() {
		$languages = $this->languageDao->selectLanguages();
		$homepage = new HomePage($languages);
		$homepage->display(isset($_GET['contributionSuccess']));
	}

	public function processContribution() {
		$languages = $this->languageDao->selectLanguages();
		if (!isset($_SESSION['user'])) {
			header('Location: index.php?action=login');
			return;
		}

		$languageCodes = array_map($this->codeExtractor, $languages);
		$errorMessages = $this->verifyContribution($languageCodes);
		if (empty($errorMessages)) {
			$this->translationDao->addContribution($_POST["source_phrase"], $_POST["source_language"], $_POST["target_phrase"], $_POST["target_language"]);
			header('Location: index.php?contributionSuccess');
		}
		else {
			$translations = $this->translationDao->selectTranslations($_POST["source_phrase"], $_POST["source_language"], $_POST["target_language"]);
			$homepage = new HomePage($languages);
			$homepage->display(false, $errorMessages, $_POST, $translations);
		}
	}


	private function verifyContribution($languageCodes) {
		$errorMessages = $this->verifySearch($languageCodes);
		if (empty($_POST["target_phrase"])) {
			$errorMessages["target_phrase"] = "Please enter a suggestion";
		}
		return $errorMessages;
	}


	private function verifySearch($languageCodes) {
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