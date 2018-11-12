<?php
/*
  Author: Bryce Brown
  Date: November 3, 2018
  This is the homepage of Bookishly
*/
  // Reguire database connection
  //require('connect.php');

  require('server.php');

  // gather all data from our book table
  $query = "SELECT * FROM book";

  $statement = $db->prepare($query);
  $statement->execute();

  $genreQuery = "SELECT * FROM genre";

  $genreStatement = $db->prepare($genreQuery);
  $genreStatement->execute();

?>

<!DOCTYPE html>
<html>
<head>
  <title></title>

  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <img id="logo" src="images/Bookishly_logo.png" alt="Logo">
  <nav>
    
    
    
    <ul>
      <li><a id="currentpage" href="index.html">Home</a></li>
      <li><a href="#">Genres</a></li>
      <li><a href="#">Recent</a></li>
    </ul>
    
  </nav>  

  <?php if(isset($_SESSION['success'])): ?>
    <h3><?= $_SESSION['success'] ?></h3>
    <?php unset($_SESSION['success']); ?>
  <?php endif ?>

  <?php if(isset($_SESSION['username'])): ?>
    <p>Welcome <?= $_SESSION['username'] ?></p>
    <p><a class="red" href="index.php?logout='1'">Logout</a></p>
  <?php endif ?>

  <h3>Recently Posted Books</h3>

    <fieldset>
            <?php if ($statement->rowCount() == 0) :?>
                <h1>No posts found.</h1>
            <?php else :?>
                <ul>
                    <?php while($row = $statement->fetch()):?>
                        <li>
                          <?= $row['Title'] ?> by <?= $row['Author'] ?>
                        </li>
                    <?php endwhile ?>    
               </ul>
           <?php endif ?> 
    </fieldset>
    <fieldset>
            <?php if ($genreStatement->rowCount() == 0) :?>
                <h1>No Genres found.</h1>
            <?php else :?>
                <ul>
                    <?php while($row = $genreStatement->fetch()):?>
                        <li>
                          <?= $row['Genre'] ?>
                        </li>
                    <?php endwhile ?>    
               </ul>
           <?php endif ?> 
    </fieldset>
  </body>
</html>