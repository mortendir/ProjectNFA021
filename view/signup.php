<?php
class SignupPage {
	public function display($errors = array(), $submittedData = array()) {
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="styles.css">
	<title>Chicken Translate &middot; Crowdsourced Translation Platform</title>
</head>
<body>
	<img src="images/chicken_logo.png" alt="Chatting chickens">
	<h1>Chicken Translate</h1>
	<div id="signup_form">
		<form action="index.php?action=dosignup" method="POST">
			<p>
				<label>Username:</label>
				<input type="text" id="username" name="username" value="<?php if(isset($submittedData["username"])) echo $submittedData["username"]; ?>" />
				<?php if(isset($errors["username"])) echo '<span class="error">' . $errors["username"] . '</span>';?>
			</p>
			<p>
				<label>Password:</label>
				<input type="password" id="password" name="password" />
				<?php if(isset($errors["password"])) echo '<span class="error">' . $errors["password"] . '</span>';?>
			</p>
			<p>
				<input type="submit" name="signup" value="Sign up" id="signup" />
			</p>
		</form>				
</body>	
<?php }
}
?>