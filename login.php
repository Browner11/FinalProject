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
  	<div class="header">Login</div>
	<form class="form" method="post" action="login.php">
		<!-- errors -->
		<?php include('errors.php'); ?>
		<div class="input-group">
			<label for="username">Username</label>
			<input type="text" id="username" name="username">
		</div>
		<div class="input-group">
			<label for="password">Password</label>
			<input type="password" id="password" name="password">
		</div>		
		</div>
		<div class="input-group">
			<button type="submit" id="login" name="login" class="btn">Login </button>
		</div>
		<p>
			Don't have an account? <a href="register.php">Register Here</a>
		</p>
	</form>



</body>
</html>
