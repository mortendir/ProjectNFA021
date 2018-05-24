<?php
	class HomePage {
		private $languages;
		public function __construct($languages) {
			$this->languages = $languages;
		}
		public function display() {

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<script src="index.js"></script>
	<link rel="stylesheet" href="styles.css"/>
	<title>Translation Page</title>
</head>
<body>
	<h1>Chicken Translate</h1>
	<form action="#" method="post" id="translation">
		<div>
			<div class="source">
				<label for="source_language">Source Language</label>
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
				<label for="target_language">Target Language</label>
				<select name="source_language" id="target_language">
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
	<script>
		var element = document.getElementById("translation");
		element.addEventListener("submit", checkFormItems);
	</script>
</body>
</html>
<?php
		}
	}
?>