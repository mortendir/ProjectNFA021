<?php
	class HomePage {
		private $languages;
		public function __construct($languages) {
			$this->languages = $languages;
		}
		public function display($errors = array(), $submittedData = array(),$targetPhrases = array()) {

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" href="styles.css"/>
	<title>Translation Page</title>
</head>
<body>
	<h1>Chicken Translate</h1>
	<form action="index.php" method="post" id="translation">
		<div>
			<div class="source">
				<label for="source_language">Source Language</label>
				<select name="source_language" id="source_language">
					<option></option>
			    	<?php
			    	foreach ($this->languages as $language) {
		    			if ($language->getCode() === $submittedData["source_language"]) {
		    				echo "<option value=\"" . $language->getCode() ."\" selected>" . $language->getName() ."</option>";
			    		} else {
			    			echo "<option value=\"" . $language->getCode() ."\">" . $language->getName() ."</option>";
			    		}
			    	}
			    	?>
			  	</select>
			  	<?php if(isset($errors["source_language"])) echo '<span class="error">' . $errors["source_language"] . '</span>';?>
			  	<div><input type="text" id="source_phrase" name="source_phrase" value="<?php if(isset($submittedData["source_phrase"])) echo $submittedData["source_phrase"]; ?>"
		  	</div>
		  </div>
		  <div>
			<div class="target">
				<label for="target_language">Target Language</label>
				<select name="target_language" id="target_language">
					<option></option>
					<?php
			    	foreach ($this->languages as $language) {
			    		if ($language->getCode() === $submittedData["target_language"]) {
		    				echo "<option value=\"" . $language->getCode() ."\" selected>" . $language->getName() ."</option>";
			    		} else {
			    			echo "<option value=\"" . $language->getCode() ."\">" . $language->getName() ."</option>";
			    		}
			    	}
			    	?>
				</select>
				<?php if(isset($errors["target_language"])) echo '<span class="error">' . $errors["target_language"] . '</span>';?>
				<div id="target_phrases"><?php foreach ($targetPhrases as $phrase) { 
					echo $phrase;
				}?></div>
			</div>
		</div>
	  	<input type="submit" name="submit" value="Translate" />
	</form>
</body>
</html>
<?php
		}
	}
?>