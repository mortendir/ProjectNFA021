<?php
	include 'database.php';
	$link = mysqli_connect("localhost","root","") or die ("Connection lost");
	mysqli_set_charset($link,'utf8');
	mysqli_select_db($link, "Translation_Project");
	$languages = select_languages($link);

	if(isset($_POST['submit'])){
		$selected_val = $_POST['source_language'];
		echo $selected_val;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Translation Page</title>
</head>
<body>
	<form action="#" method="post">
		<div>
			<div class="source">
				<select name="source_language">
					<option>Source language &darr;</option>
			    	<?php
			    	foreach ($languages as $code => $name) {
			    		echo "<option value=\"$code\">$name</option>";
			    	}
			    	?>
			  	</select>
		  	</div>
			<div class="target">
				<select name="source_language">
					<option>Target language &darr;</option>
				</select>
			</div>
	  	</div>
	  	<input type="submit" name="submit" value="Translate" />
	</form>	
</body>
</html>