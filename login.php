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
	<img id="logo" src="images/Bookishly_logo.png" alt="Logo">
  <nav> 
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="#">Genres</a></li>
      <li><a href="newBook.php">New Book</a></li>
      <li><a class="right" href="register.php">Register</a></li>
      <li><a class="right" id="currentpage" href="login.php">Login</a></li>
    </ul>    
  </nav> 
  	<div class="header">Login</div>
	<form method="post" action="login.php">
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
