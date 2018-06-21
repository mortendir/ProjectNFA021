 <?php
 
	class HomePage {
		private $languages;
		public function __construct($languages) {
			$this->languages = $languages;
		}
		public function display($contributionSuccessful = false, $errors = array(), $submittedData = array(), $translations = array()) {
	
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
	<?php
	if ($contributionSuccessful) { ?>
		<p id="banner">Contribution chickenfully added. Thanks a cluck!</p>
	<?php }	?>
	<img src="images/chicken_logo.png" alt="Chatting chickens">
	<header>
		<h1>Chicken Translate</h1>
		<?php 
		if (isset($_SESSION['user'])) {
			echo '<div id="links"><p>Welcome ' . $_SESSION['user'] . '</p>';
			echo '<a href="index.php?action=dologout">Log out</a></div>';
		} else {
			echo '<div id="links"><a href="index.php?action=login">Log in</a>';
			echo '<a href="index.php?action=signup">Sign up</a></div>';
		}
		?>
	</header>
	<div id="main">
		<form action="index.php" method="post" id="translation">
			<input type="hidden" id="action" name="action" value="dotranslate">
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
					if (empty($errors) && !empty($submittedData) || !empty($errors['target_phrase'])) {
						echo "<div id='target_phrases'>";
						foreach ($translations as $translation) { 
							echo "<div class='translated_phrase'>" . $translation->getContent() ."</div><br>";
							foreach ($translation->getSamplePhrases() as $sample) {
								echo "<div id='sample_phrases'>" . $sample ."</div><br>";
							}
							echo "</div>";
						}
						if (empty($errors['target_phrase'])) { ?>
						<div>
							<p id="contribution_message">Would you like to <span id="contribute">add a translation</span>?</p> 
							<?php } ?>
							<div id="translation_panel" class="<?php if (empty($errors['target_phrase'])) echo 'hidden'; else echo 'visible'; ?>">
								<label>Suggestion</label>
								<input type="text" name="target_phrase" id="suggestion" placeholder="Suggestion goes here" value="<?php if(isset($submittedData["target_phrase"])) echo $submittedData["target_phrase"]; ?>" />
								<?php if(isset($errors["target_phrase"])) echo '<span class="error">' . $errors["target_phrase"] . '</span>';?>
							</div>
						</div>	
							<?php
						}
						echo "</div>";?>
					</div>
		  			<input type="submit" name="translate" value="<?php if (empty($errors['target_phrase'])) echo 'Translate'; else echo 'Send'; ?>" id="translate_button" />
			</div>
		</form>
	</div>
	<script>
	main();
<?php
if (!empty($errors['target_phrase'])) { ?>
    lockTranslation();
<?php 
} ?>

	function main() {
		var contributeLink = document.querySelector('#contribute');
		if (contributeLink != null) {
			contributeLink.addEventListener("click", showSentenceContributionForm, false);
		}

		function showSentenceContributionForm() {
		    document.querySelector("#translation_panel").style.display = "block";
		    document.querySelector("#contribution_message").style.display = "none";
		    document.querySelector("#translate_button").value = "Send";
		    lockTranslation();
		}
	}

	function lockTranslation() {
	    document.querySelector("#action").value = "docontribute";
	    document.querySelector("#source_phrase").readOnly = true;
	    transformIntoReadOnlyInput("#source_language");
	    transformIntoReadOnlyInput("#target_language");

	    function transformIntoReadOnlyInput(id) {
			var langList = document.querySelector(id);
			var value = langList.options[langList.selectedIndex].value;
			
			var input = document.createElement("input");
			input.setAttribute("type", "text");
			input.setAttribute("name", langList.name);
			input.setAttribute("id", langList.id);
			input.setAttribute("readOnly", "true");
			input.setAttribute("value", value);

			langList.parentNode.replaceChild(input, langList);
		}
	}
	</script>
</body>
</html>
<?php
		}
	}
?>