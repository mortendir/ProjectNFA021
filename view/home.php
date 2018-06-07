<?php
	class HomePage {
		private $languages;
		public function __construct($languages) {
			$this->languages = $languages;
		}
		public function display($errors = array(), $submittedData = array(), $translations = array()) {

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" href="styles.css"/>
	<title>Chicken Translate &middot; Crowdsourced Translation Platform</title>
</head>
<body>
	<h1>Chicken Translate</h1>
	<form action="index.php" method="post" id="translation">
		<div id="translation_settings">
			<div class="source">
				<div>
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
			  	</div>
			  	<div>
					<label for="source_phrase">Source Phrase</label>
			  		<input type="text" id="source_phrase" name="source_phrase" value="<?php if(isset($submittedData["source_phrase"])) echo $submittedData["source_phrase"]; ?>" />
			  		<?php if(isset($errors["source_phrase"])) echo '<span class="error">' . $errors["source_phrase"] . '</span>';?>
		  		</div>
			</div>
			<div class="target">
				<div>
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
				</div>
				<?php 
				if (empty($errors) && !empty($submittedData)) {
					if (empty($translations)) {
						echo "Sorry, no translation is found."; 
					} else {
						echo '<div id="target_phrases">';
						foreach ($translations as $translation) { 
							echo $translation->getContent()."<br>";
							foreach ($translation->getSamplePhrases() as $sample) {
								echo $sample."<br>";
							}
						}
						echo '</div>';
					} 
				}?>
				</div>
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