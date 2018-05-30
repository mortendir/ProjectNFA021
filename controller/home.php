<?php
	require_once 'model/language_dao.php';
	require_once 'view/home.php';

	class HomeController {
		private $languageDao;
		public function __construct($languageDao) {
			$this->languageDao = $languageDao;
		}
		public function process() {
			$languages = $this->languageDao->selectLanguages();
			$homepage = new HomePage($languages);
			$homepage->display();
		}
	}
?>