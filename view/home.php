<?php
	class HomePage {
		private $languages;
		public function __construct($languages) {
			$this->languages = $languages;
		}
		public function display($errors = array()) {

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
				<label for="source_language">Source Language <?php if(isset($errors["source_language"])) echo $errors["source_language"];?></label>
				<select name="source_language" id="source_language">
					<option></option>
			    	<?php
			    	foreach ($this->languages as $language) {
			    		echo "<option value=\"" . $language->getCode() ."\">" . $language->getName() ."</option>";
			    	}
			    	?>
			  	</select>
			  	<!-- add div class error -->
		  	</div>
			<div class="target">
				<label for="target_language">Target Language <?php if(isset($errors["target_language"])) echo $errors["target_language"];?></label>
				<select name="target_language" id="target_language">
					<option></option>
					<?php
			    	foreach ($this->languages as $language) {
			    		echo "<option value=\"" . $language->getCode() ."\">" . $language->getName() ."</option>";
			    	}
			    	?>
				</select>
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