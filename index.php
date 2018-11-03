<?php
/*
  Author: Bryce Brown
  Date: November 3, 2018
  This is the homepage of Bookishly
*/
  // Reguire database connection
  require('connect.php');

  // gather all data from our book table
  $query = "SELECT * FROM book";

  $statement = $db->prepare($query);
  $statement->execute();

?>

  <h3>Recently Posted</h3>

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
  </body>
</html>