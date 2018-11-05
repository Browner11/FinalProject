<?php
/*
  Author: Bryce Brown
  Date: November 3, 2018
  This is the homepage of Bookishly
*/
  // Reguire database connection
  //require('connect.php');

  require('server.php');
  require('authenticate.php');

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
<html>
<head>
  <title></title>

</head>
<body>

  
  <h3>All Users</h3>

    <fieldset>
            <?php if ($statement->rowCount() == 0) :?>
                <h1>No users found.</h1>
            <?php else :?>
                <ul>
                    <?php while($row = $statement->fetch()):?>
                        <li>
                          <?= $row['Username'] ?> ---
                          <?= $row['Password'] ?>                        
                        </li>
                    <?php endwhile ?>    
               </ul>
           <?php endif ?> 
    </fieldset> 
    <fieldset>  
    <form method="post" action="admin.php">
    	<div class="input-group">
      <label for="deletebox">User to Delete:</label>
    	<input type="text" name="deleteuser" id="deleteuser">
      </div>
      <div class="input-group">
    	<button type="submit" id="delete" name="delete" class="btn">Delete </button>
    </div>
    </form>
  </fieldset>
  <fieldset>
    <form method="post" action="admin.php">
    <!-- errors -->
    <?php include('errors.php'); ?>
    <div class="input-group">
      <label for="username">Username to Add:</label>
      <input type="text" id="username" name="username">
    </div>
    <div class="input-group">
      <label for="username">Email:</label>
      <input type="email" id="email" name="email">
    </div>
    <div class="input-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password">
    </div>
    <div class="input-group">
      <label for="confirmPassword">Confirm Password:</label>
      <input type="password" id="confirmPassword" name="confirmPassword">
    </div>
    <div class="input-group">
      <button type="submit" id="register" name="register" class="btn">Add </button>
    </div>
  </fieldset>
  </body>
</html>