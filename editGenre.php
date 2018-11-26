<?php 
    
    include('server.php');

    
    $genreQuery = "SELECT * FROM genre";

    $genreStatement = $db->prepare($genreQuery);
    $genreStatement->execute();

  

// if Add genre button is submitted
if(isset($_POST['addGenre'])){
    $genre = $_POST['genre'];
    
            $query = "INSERT INTO genre (genre) VALUES ('$genre')";
            $statement = $db->prepare($query);
            $statement->execute();
            
            $_SESSION['success'] = "You created a new genre";

            header("location: editGenre.php");
}

if(isset($_POST['deleteGenre'])){
    $genreRadio = $_POST['genreRadio'];    
            
    $deleteQuery = "DELETE FROM genre WHERE genre = '$genreRadio' LIMIT 1";

    $deleteStatement = $db->prepare($deleteQuery);
    $deleteStatement->execute();

    header("location: editGenre.php");
}

if(isset($_POST['editGenre'])){
    $genreRadio = $_POST['genreRadio'];   
    $genre = $_POST['genre']; 
            
    $deleteQuery = "UPDATE genre SET genre = '$genre' WHERE genre = '$genreRadio'";

    $deleteStatement = $db->prepare($deleteQuery);
    $deleteStatement->execute();

    header("location: editGenre.php");
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
  
  <div class="header">Edit Genres</div>
        <form class="form" method="post" action="editGenre.php">
        <?php if ($_SESSION['UserType'] == "1") :?>
        
        <fieldset id="genreRadio">
            <?php while($genreRow = $genreStatement->fetch()):?>
        <input type="radio" name="genreRadio" value="<?= $genreRow['Genre'] ?>"> <?= $genreRow['Genre'] ?><br>
            <?php endwhile ?>
        </fieldset>
        <?php else : ?>
            <?php while($genreRow = $genreStatement->fetch()):?>
        <p><?= $genreRow['Genre'] ?></p>
            <?php endwhile ?>
        <?php endif ?>
        <?php if(!isset($_SESSION['login'])): ?>
            <br>
            <p class="message">You must be logged in to add genres.</p>
        <?php else :?>          
            
            <?php if ($_SESSION['UserType'] == "1") :?>
                <div class="input-group">
                <label for="genre">Add / Update To:</label>
                <input type="text" id="genre" name="genre">
                </div>
                <button type="submit" id="addGenre" name="addGenre">Add Genre</button>
                <button type="submit" name="editGenre">Edit Genre</button>
                <button type="submit" name="deleteGenre">Delete Genre</button> 
                <br>  
                <p class="message">Warning: Delete can not be undone.</p>
            <?php else : ?>
                <div class="input-group">
                <label for="genre">Add:</label>
                <input type="text" id="genre" name="genre">
                </div>
                <button type="submit" id="addGenre" name="addGenre">Add Genre</button>
            <?php endif ?> 
    <?php endif ?>
    </form>



</body>
</html>