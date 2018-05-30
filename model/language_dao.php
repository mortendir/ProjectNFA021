<?php
	require_once 'language.php';

	class LanguageDao {
		private $link;

		public function __construct($link) {
			$this->link = $link;
		}

		public function selectLanguages() {
			$sql = "SELECT name,code FROM Languages ORDER BY name ASC";
			$result = mysqli_query($this->link, $sql);
			$array = array();
			while ($row = mysqli_fetch_row($result)) {
				$name = $row[0]; 
				$code = $row[1];
				$language = new Language ($name, $code);
				array_push($array, $language);
			}
			mysqli_free_result($result);
			return $array; 
		}
	}
?>