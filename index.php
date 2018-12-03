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
  <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
</head>
<body>  
  <?php include('nav.php'); ?>

  <h3>Recently Posted Books</h3>

    <fieldset>
            <?php if ($statement->rowCount() == 0) :?>
                <h1>No posts found.</h1>
            <?php else :?>
                <ul>
                    <?php while($row = $statement->fetch()):?>
                        <li>
                          <?php $rowID = $row['ISBN'] ?>
                          <?= "<a href=fullPage.php?ISBN=$rowID>" . $row['Title'] . "</a>" . " by " . $row['Author'] ;?>
                        </li>
                    <?php endwhile ?>    
               </ul>
           <?php endif ?> 
    </fieldset>
  </body>
</html>