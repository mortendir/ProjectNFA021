<?php
class Translation {
	private $content;
	private $samplePhrases;

	public function __construct($content, $samplePhrases) {
		$this->content = $content;
		$this->samplePhrases = $samplePhrases;
	}
	public function getContent() {
		return $this->content;
	}
	public function getSamplePhrases() {
		return $this->samplePhrases;
	}
}
?>