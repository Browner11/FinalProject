<?php

	include('server.php'); 

    $ISBN = '';

     if(isset($_GET['ISBN']))
     {
        $_SESSION['ISBN'] = $_GET['ISBN'];
        $ISBN = $_GET['ISBN'];
     }
     else
     {
        $ISBN = $_SESSION['ISBN'];
     }

	$query = "SELECT * FROM book WHERE ISBN = $ISBN";

     // statment is prepared for execution
     $statement = $db->prepare($query);

     // Execution on the DB server is delayed until we execute(). 
     $statement->execute();
     
     $commentQuery = "SELECT * FROM comment WHERE ISBN = $ISBN";
     $commentStatement = $db->prepare($commentQuery);
     $commentStatement->execute();

    if(isset($_POST['postComment'])){  
        $UserId = $_SESSION['UserId'];
        $Comment = $_POST['comment'];       
        
        $commentQuery = "INSERT INTO comment (ISBN, UserId, Comment) VALUES ('$ISBN', '$UserId', '$Comment')";

        $commentStatement = $db->prepare($commentQuery);
        $commentStatement->execute();            

        header('location: fullPage.php');
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
    <div class="bookcontent">
        <div class="bookimage">    	
            <?php if ($statement->rowCount() == 0) :?>
            	<h1>No book found.</h1>
            <?php else :?>
                <?php while($row = $statement->fetch()):?>
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
                    
                <?php endwhile ?>    
             <?php endif?>             
        </div>
    </div>
     <div class="newcomment">
        <?php if(!isset($_SESSION['login'])): ?>
            <h1>Please <a href="login.php">Log In</a> to post comments.</h1>
        <?php else :?>
                <form  method="post" action="fullPage.php">
                    <div class="input-group">
                        <label for="Comment">What do you think about this book?</label>
                        <input type="text" id="comment" name="comment">
                    </div>
                    <div class="input-group">
                        <button type="submit" id="postComment" name="postComment">Submit Comment</button>
                    </div>
                </form>

                
        <?php endif ?>        
    </div>
    <div class="comments">
        <?php if ($commentStatement->rowCount() == 0) :?>
            <h1>No comments found.</h1>
        <?php else :?>
            <ul>
                <?php while($commentRow = $commentStatement->fetch()):?>
                    <div class="commentblock"><li><?= $commentRow['Comment'] ?></li></div>

                <?php endwhile ?>
            </ul>
        <?php endif ?>        
    </div>
</body>
</html>