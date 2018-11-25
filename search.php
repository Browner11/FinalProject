<?php

  require('server.php');

  // gather all data from our book table
  // if search button is clicked
  if(isset($_POST['search'])){  

    $search = "%" . $_POST['searchbar'] . "%";
    $genre = $_POST['searchgenre'];
  

    if($genre == "All Genres"){

      $query = "SELECT * FROM book WHERE Title LIKE '$search' OR Author LIKE '$search'" ;

      $statement = $db->prepare($query);
      $statement->execute();
    }
    else
    {
      $query = "SELECT * FROM book WHERE Genre = '$genre' AND (Title LIKE '$search' OR Author LIKE '$search')" ;

      $statement = $db->prepare($query);
      $statement->execute();
    }  
  }

  if(isset($_GET['Genre']))
  {
    $genre = $_GET['Genre'];  

    if($genre == "AllGenres"){

      $query = "SELECT * FROM book" ;

      $statement = $db->prepare($query);
      $statement->execute();
    }
    else
    {
      $query = "SELECT * FROM book WHERE Genre = '$genre'" ;

      $statement = $db->prepare($query);
      $statement->execute();
    }   
  }
 
?>

<!DOCTYPE html>
<html>
<head>
  <title></title>

  <link rel="stylesheet" type="text/css" href="formstyle.css">
</head>
<body>  
  <?php include('nav.php'); ?>

  
  <h3>Search Results</h3>
      <fieldset>
            <?php if ($statement->rowCount() == 0) :?>
                <h1>No books found matching search terms.</h1>
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