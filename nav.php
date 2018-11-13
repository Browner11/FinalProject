<?php



?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<img id="logo" src="images/Bookishly_logo.png" alt="Logo">
  <nav>    
    <ul>
      <li><a id="currentpage" href="index.php">Home</a></li>
      <li><a href="genres.php">Genres</a></li>
      <li><a href="newBook.php">New Book</a></li>
      <?php if(isset($_SESSION['login'])): ?>
      <li class="right">Welcome, <?=$_SESSION['username'] ?></li>
      <p><a class="right" class="red" href="index.php?logout='1'">Logout</a></p>
      <?php else : ?>
      <li><a class="right" href="register.php">Register</a></li>
      <li><a class="right" href="login.php">Login</a></li>
 	  <?php endif ?>
    </ul>    
  </nav>  
</body>
</html>