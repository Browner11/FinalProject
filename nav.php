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
      <li><a class="left" id="currentpage" href="index.php">Home</a></li>
      <li><a class="left" href="genres.php">Genres</a></li>      
      <?php if(isset($_SESSION['login'])): ?>
      	<li><a class="left" href="newBook.php">New Book</a></li>
        <li class="right"><a href="index.php?logout='1'">Logout</a></li>
        <li class="welcome">Welcome, <?=$_SESSION['username'] ?></li>
      <?php else : ?>
        <li><a class="right" href="register.php">Register</a></li>
        <li><a class="right" href="login.php">Login</a></li>
 	  <?php endif ?>
    </ul>    
  </nav>  
</body>
</html>