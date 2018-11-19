<?php
	
	include('server.php');

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="formstyle.css">
</head>
	
<body>
	<?php include('nav.php'); ?>
	<div class="header">Register</div>
	<form class="form" method="post" action="register.php">
		<!-- errors -->
		<?php include('errors.php'); ?>
		<div class="input-group">
			<label for="username">Username</label>
			<input type="text" id="username" name="username">
		</div>
		<div class="input-group">
			<label for="username">Email</label>
			<input type="email" id="email" name="email">
		</div>
		<div class="input-group">
			<label for="password">Password</label>
			<input type="password" id="password" name="password">
		</div>
		<div class="input-group">
			<label for="confirmPassword">Confirm Password</label>
			<input type="password" id="confirmPassword" name="confirmPassword">
		</div>
		<div class="input-group">
			<button type="submit" id="register" name="register" class="btn">Register </button>
		</div>
		<p>
			Already have an account? <a href="login.php">Log in</a>
		</p>

	</form>



</body>
</html>
