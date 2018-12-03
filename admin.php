<?php
/*
  Author: Bryce Brown
  Date: November 3, 2018
  This is the homepage of Bookishly
*/
  // Reguire database connection
  //require('connect.php');

  require('server.php'); 

  if($_SESSION['UserType'] != "1")
  {
    header("location: index.php");
  }

  // gather all data from our book table
  $query = "SELECT * FROM user";

  $statement = $db->prepare($query);
  $statement->execute();

  if(isset($_POST['delete'])) {
    $deleteUser = $_POST['deleteuser'];
  	$deleteQuery = "DELETE FROM user WHERE username = :username LIMIT 1";

  	$deleteStatement = $db->prepare($deleteQuery);
    $deleteStatement->bindValue(':username', $deleteUser);
  	$deleteStatement->execute();

    echo "Trying to delete!";
    header('location: admin.php');
  }


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Tools</title>
<link rel="stylesheet" type="text/css" href="formstyle.css">
<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
</head>
<body>
  <?php include('nav.php'); ?>

  
  <h3>All Users</h3>

    <fieldset>
            <?php if ($statement->rowCount() == 0) :?>
                <h1>No users found.</h1>
            <?php else :?>
                <ul>
                    <?php while($row = $statement->fetch()):?>
                        <li>
                          <?= $row['Username'] ?> ---
                          <?php if($row['UserType'] == 0): ?>
                          Regular User                       
                          <?php else : ?>
                            Admin User
                          <?php endif ?>
                        </li>
                    <?php endwhile ?>    
               </ul>
           <?php endif ?> 
    </fieldset> 
    <fieldset>  
    <form method="post" action="admin.php">
    	<div class="input-group">
      <label for="deleteuser">User to Delete:</label>
    	<input type="text" name="deleteuser" id="deleteuser">
      </div>
      <div class="input-group">
    	<button type="submit" id="delete" name="delete" class="btn">Delete </button>
    </div>
    </form>
  </fieldset>  
  </body>
</html>