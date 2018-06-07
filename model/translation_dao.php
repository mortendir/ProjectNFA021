<?php
require_once 'translation.php';

class TranslationDao {
	private $link;

	public function __construct($link) {
		$this->link = $link;
	}	

	public function selectTranslations($sourcePhrase, $sourceLanguage, $targetLanguage) {

		$sql = "SELECT target_phrase.phrase AS phrase, JSON_ARRAYAGG(sample_phrase.content) AS content_json
				FROM  Phrases source_phrase
				INNER JOIN Languages source_language ON source_language.id = source_phrase.language_id
				INNER JOIN Translations translation ON translation.source_phrase_id = source_phrase.id
				INNER JOIN Phrases target_phrase ON translation.target_phrase_id = target_phrase.id
				INNER JOIN Languages target_language ON target_language.id = target_phrase.language_id
				INNER JOIN SamplePhrases sample_phrase ON sample_phrase.phrase_id = target_phrase.id
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
				INNER JOIN SamplePhrases sample_phrase ON sample_phrase.phrase_id = source_phrase.id
				WHERE (target_phrase.phrase = '$sourcePhrase'
				AND target_language.code = '$sourceLanguage'
				AND source_language.code = '$targetLanguage')
				GROUP BY source_phrase.phrase";
		
		$array = array();
		
		$result = mysqli_query($this->link, $sql) or die (mysqli_error($this->link)); 
			while ($row = mysqli_fetch_row($result)) {
				$phrase = $row[0];
				$samplePhrases = json_decode($row[1]);
				$translation = new Translation($phrase, $samplePhrases);
				array_push($array, $translation);
			}
			mysqli_free_result($result);
		
		return $array; 
	}

}

?>
