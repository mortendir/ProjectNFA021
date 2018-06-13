<?php
class Language {
	private $name;
	private $code;

	public function __construct($name,$code) {
		$this->name = $name;
		$this->code = $code;
	}
	public function getName() {
		return $this->name;
	}
	public function getCode() {
		return $this->code;
	}
}
?>