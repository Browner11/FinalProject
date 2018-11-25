<?php

	include('server.php'); 

	$query = "SELECT * FROM book";

     // statment is prepared for execution
     $statement = $db->prepare($query);

     // Execution on the DB server is delayed until we execute(). 
     $statement->execute();

     $ISBN = $_GET['ISBN'];

     $commentQuery = "SELECT * FROM comment WHERE ISBN == $ISBN";
     $commentStatement = $db->prepare($commentQuery);
     $commentStatement->execute();


?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="formstyle.css">
</head>
<body>
	<?php include('nav.php'); ?>
    <div class="bookcontent">
        <div class="bookimage">    	
            <?php if ($statement->rowCount() == 0) :?>
            	<h1>No book found.</h1>
            <?php else :?>
                <?php while($row = $statement->fetch()):?>
                	<?php if ($row['ISBN'] == $_GET['ISBN']) : ?>
                        <img src="uploads/<?=$row['CoverImg'] ?>">                      	
        </div>
        <div class="bookdetails">
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
             <?php endif?>             
        </div>
    </div>
    <div class="comments">
        <?php if ($commentStatement->rowCount() == 0) :?>
            <h1>No comments found.</h1>
        <?php else :?>
                <?php while($commentRow = $commentStatement->fetch()):?>

                <?php endwhile ?>
        <?php endif ?>        
    </div>
</body>
</html>