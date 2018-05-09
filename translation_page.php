<!DOCTYPE html>
<html>
<head>
	<title>Translation Page</title>
</head>
<body>
	<p>
	<form action="#" method="post">
		Source Language<br>
		<select name = "language_s">
	    <option value="English">English</option>
	    <option value="French">French</option>
	    <option value="Spanish">Spanish</option>
	    <option value="Turkish">Turkish</option>
	    <option value="German">German</option>
	  </select>
	  <input type="submit" name="submit" value="Selected Value"/>
	</form>
		<?php
		if(isset($_POST['submit'])){
			$selected_val = $_POST['language_s'];
			echo $selected_val;
		}
		?>
	</p>
</body>
</html>