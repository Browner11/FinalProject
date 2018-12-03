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

     if(isset($_GET['selected']))
     {        
        $selectedComment= $_GET['selected'];
     }
     



	$query = "SELECT * FROM book WHERE ISBN = $ISBN";

     // statment is prepared for execution
     $statement = $db->prepare($query);

     // Execution on the DB server is delayed until we execute(). 
     $statement->execute();
     
     $commentQuery = "SELECT * FROM comment WHERE ISBN = $ISBN ORDER BY PostDate DESC";
     $commentStatement = $db->prepare($commentQuery);
     $commentStatement->execute();



    if(isset($_POST['postComment'])){  
        $UserId = $_SESSION['UserId'];
        $Comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);  
        $User = $_SESSION['username'];  
        
        $commentQuery = "INSERT INTO comment (ISBN, UserId, User, Comment) VALUES ('$ISBN', '$UserId', '$User', '$Comment')";

        $commentStatement = $db->prepare($commentQuery);
        $commentStatement->execute();            

        header('location: fullPage.php');
    }

    if(isset($_POST['deleteComment'])){      
            
    $deleteQuery = "DELETE FROM comment WHERE commentId = '$selectedComment' LIMIT 1";

    $deleteStatement = $db->prepare($deleteQuery);
    $deleteStatement->execute();

    header("location: fullPage.php");
    }

    if(isset($_POST['deleteBook'])){      
            
    $deleteBookQuery = "DELETE FROM book WHERE ISBN = '$ISBN' LIMIT 1";

    $deleteBookStatement = $db->prepare($deleteBookQuery);
    $deleteBookStatement->execute();

    header("location: index.php");
    }
   


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Book Details</title>
	<link rel="stylesheet" type="text/css" href="formstyle.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
</head>
<body>
	<?php include('nav.php'); ?>
    <div class="bookcontent">
        <div class="bookimage">    	
            <?php if ($statement->rowCount() == 0) :?>
            	<h1>No book found.</h1>
            <?php else :?>
                <?php while($row = $statement->fetch()):?>
                <?php  $_SESSION['editGenre'] = $row['Genre']; ?>
                        <img src="uploads/<?=$row['CoverImg'] ?>">                      	
        </div>
        <div class="bookdetails">
                        <ul>
                            <li>
                              <?= "<h4> Title: " . $row['Title'] . "</h4>";?>
                              <?= "<br>";?>
                              <?= "<p> Author: " . $row['Author'] . "</p>";?>
                              <?= "<p> Genre: " . $row['Genre'] . "</p>";?>
                              <?= "<p> Released: " . $row['ReleaseYear'] . "</p>";?>
                              <?= "<br>";?>
                            </li>
                        </ul>
                        <?php if ($_SESSION['UserType'] == "1") :?>
                        <form method="post" action="editBook.php">
                        <button type="submit">Edit Book Details</button>
                        </form>
                        <form method="post" action="fullPage.php">                      
                        <button type="submit" name="deleteBook" onclick="return confirm('Are you sure you want to delete this item? This action can not be undone.');">Delete Book</button>
                        </form>
                        <?php endif ?>
                    
                <?php endwhile ?>    
             <?php endif?>             
        </div>
    </div>
     <div class="newcomment">
        <?php if(!isset($_SESSION['login'])): ?>
            <h1>Please <a href="login.php">Log In</a> to post comments.</h1>
        <?php else :?>
                <form class="center" method="post" action="fullPage.php">
                   
                    <div  id="comment" class="input-group">
                        <label for="Comment">What do you think about this book?</label>
                        <textarea rows="5" cols="75" name="comment" id="comment"></textarea>
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

                    <div class="commentblock">

                    <li><?= $commentRow['Comment'] ?></li>
                    <p>Posted by <?= $commentRow['User'] ?> at <?= $commentRow['PostDate'] ?></p> 
                    <?php if ($_SESSION['UserType'] == "1"): ?>
                        <form method="post" action="fullPage.php?selected=<?= $commentRow['CommentId'] ?>">
                        <button class="commentDelete" name="deleteComment">Delete Comment</button>
                        </form>
                    <?php endif ?>                   
                    </div>

                <?php endwhile ?>
            </ul>
        <?php endif ?>        
    </div>
</body>
</html>