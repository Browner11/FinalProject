<?php

	include('server.php'); 

	$query = "SELECT * FROM book";

     // statment is prepared for execution
     $statement = $db->prepare($query);

     // Execution on the DB server is delayed until we execute(). 
     $statement->execute();


?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="formstyle.css">
</head>
<body>
	<?php include('nav.php'); ?>
	<fieldset>
        <?php if ($statement->rowCount() == 0) :?>
        	<h1>No tweets found.</h1>
        <?php else :?>
            <?php while($row = $statement->fetch()):?>
            	<?php if ($row['ISBN'] == $_GET['ISBN']) : ?>
                    <img src="uploads/<?=$row['CoverImg'] ?>">
                    <ul>
	                    <li>
	                      <?= "<h4>" . $row['Title'] . "</h4>";?>
	         		      <?= "<p>" . $row['Author'] . "</p>";?>
	                      <?= "<p>" . $row['Genre'] . "</p>";?>
	                      <?= "<br>";?>
	                    </li>
	                </ul>
            	<?php endif?>
             <?php endwhile ?>    
         <?php endif ?> 
    </fieldset>
</body>
</html>