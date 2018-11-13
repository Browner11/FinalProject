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

  <link rel="stylesheet" type="text/css" href="formstyle.css">
</head>
<body>
  <?php include('nav.php'); ?>

  <?php if(isset($_SESSION['success'])): ?>
    <h3><?= $_SESSION['success'] ?></h3>
    <?php unset($_SESSION['success']); ?>
  <?php endif ?>

  <?php if(isset($_SESSION['username'])): ?>
    <p>Welcome <?= $_SESSION['username'] ?></p>
    <p><a class="red" href="index.php?logout='1'">Logout</a></p>
  <?php endif ?>

  <h3>All Genres</h3>    
    <fieldset>
            <?php if ($genreStatement->rowCount() == 0) :?>
                <h1>No Genres found.</h1>
            <?php else :?>
                <ul>
                    <?php while($row = $genreStatement->fetch()):?>
                        <li class="boldgenre">
                          <?= $row['Genre'] ?>
                        </li>   
                        <!-- <ul>
                        <?php while($newRow = $statement->fetch()):?>
                           <?php if($newRow['Genre'] == $row['Genre']): ?>
                              <li>
                                <?=$newRow['Title'] ?> by <?= $newRow['Author'] ?>
                              </li>
                           <?php endif ?>
                        <?php endwhile ?> 
                        </ul>                -->  
                    <?php endwhile ?>    
               </ul>
           <?php endif ?> 
    </fieldset>
  </body>
</html>