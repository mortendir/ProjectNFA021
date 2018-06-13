<?php
require_once 'translation.php';

class TranslationDao {
	private $link;

	public function __construct($link) {
		$this->link = $link;
	}

	public function selectTranslations($sourcePhrase, $sourceLanguage, $targetLanguage) {
		$sourcePhrase = mysqli_real_escape_string($this->link, $sourcePhrase);
		$sourceLanguage = mysqli_real_escape_string($this->link, $sourceLanguage);
		$targetLanguage = mysqli_real_escape_string($this->link, $targetLanguage);

		$sql = "SELECT target_phrase.phrase AS phrase, JSON_ARRAYAGG(sample_phrase.content) AS content_json
				FROM  Phrases source_phrase
				INNER JOIN Languages source_language ON source_language.id = source_phrase.language_id
				INNER JOIN Translations translation ON translation.source_phrase_id = source_phrase.id
				INNER JOIN Phrases target_phrase ON translation.target_phrase_id = target_phrase.id
				INNER JOIN Languages target_language ON target_language.id = target_phrase.language_id
				LEFT OUTER JOIN SamplePhrases sample_phrase ON sample_phrase.phrase_id = target_phrase.id
				WHERE (source_phrase.phrase = '$sourcePhrase'
				AND source_language.code = '$sourceLanguage'
				AND target_language.code = '$targetLanguage')
				GROUP BY target_phrase.phrase
				UNION ALL
				SELECT source_phrase.phrase AS phrase, JSON_ARRAYAGG(sample_phrase.content) AS content_json
				FROM  Phrases source_phrase
				INNER JOIN Languages source_language ON source_language.id = source_phrase.language_id
				INNER JOIN Translations translation ON translation.source_phrase_id = source_phrase.id
				INNER JOIN Phrases target_phrase ON translation.target_phrase_id = target_phrase.id
				INNER JOIN Languages target_language ON target_language.id = target_phrase.language_id
				LEFT OUTER JOIN SamplePhrases sample_phrase ON sample_phrase.phrase_id = source_phrase.id
				WHERE (target_phrase.phrase = '$sourcePhrase'
				AND target_language.code = '$sourceLanguage'
				AND source_language.code = '$targetLanguage')
				GROUP BY source_phrase.phrase";

		$array = array();
		$result = mysqli_query($this->link, $sql) or die (mysqli_error($this->link)); 
			while ($row = mysqli_fetch_row($result)) {
				$phrase = $row[0];
				$samplePhrases = json_decode($row[1]);
				if (count($samplePhrases) == 1 && $samplePhrases[0] == null) {
					$samplePhrases = array();
				}
				$translation = new Translation($phrase, $samplePhrases);
				array_push($array, $translation);
			}
			mysqli_free_result($result);
		
		return $array; 
	}


	public function addContribution($sourcePhrase, $sourceLanguage, $targetPhrase, $targetLanguage) { 
		$this->insertPhraseIfNotExists($sourcePhrase, $sourceLanguage);
		$this->insertPhraseIfNotExists($targetPhrase, $targetLanguage);
		
		$sourcePhrase = mysqli_real_escape_string($this->link, $sourcePhrase);
		$sourceLanguage = mysqli_real_escape_string($this->link, $sourceLanguage);
		$targetPhrase = mysqli_real_escape_string($this->link, $targetPhrase);
		$targetLanguage = mysqli_real_escape_string($this->link, $targetLanguage);
		$sql = "INSERT INTO Translations(`source_phrase_id`, `target_phrase_id`) SELECT match_phrase('$sourcePhrase', '$sourceLanguage'), match_phrase('$targetPhrase','$targetLanguage')";
		mysqli_query($this->link, $sql) or die (mysqli_error($this->link));
	}

	private function insertPhraseIfNotExists($sourcePhrase, $sourceLanguage) {
		$sourcePhraseExists = $this->phraseExists($sourcePhrase, $sourceLanguage);
		$sourcePhrase = mysqli_real_escape_string($this->link, $sourcePhrase);
		$sourceLanguage = mysqli_real_escape_string($this->link, $sourceLanguage);
		if (!$sourcePhraseExists) {
			$sql = "INSERT INTO Phrases(`language_id`, `phrase`) SELECT `id`, '$sourcePhrase' FROM Languages WHERE `code` = '$sourceLanguage'";
			mysqli_query($this->link, $sql) or die (mysqli_error($this->link));
		}
	}

	private function phraseExists($phrase, $language) {
		$phrase = mysqli_real_escape_string($this->link, $phrase);
		$language = mysqli_real_escape_string($this->link, $language);
		$sql = "SELECT COUNT(p.id) FROM Phrases p INNER JOIN Languages l ON p.language_id = l.id WHERE l.code = '$language' AND p.phrase = '$phrase'";
		$result = mysqli_query($this->link, $sql) or die (mysqli_error($this->link)); 
		while ($row = mysqli_fetch_row($result)) {
			$count = $row[0]; 
		}
		mysqli_free_result($result);
		if ($count == 0) {
			return false;
		} else {
			return true;
		}
	}

}

?>
