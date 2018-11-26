<?php 
    
    include('server.php');

    $ISBN = $_SESSION['ISBN'];
    $currentGenre = $_SESSION['editGenre'];

    $query = "SELECT * FROM book WHERE ISBN = $ISBN";

    $statement = $db->prepare($query);
    $statement->execute();

    $genreQuery = "SELECT * FROM genre";

    $genreStatement = $db->prepare($genreQuery);
    $genreStatement->execute();


  $isValid = null;

  if (!isset($_POST['file'])) {
      $isValid = true;
  }
    // file_upload_path() - Safely build a path String that uses slashes appropriate for our OS.
    // Default upload path is an 'uploads' sub-folder in the current folder.
    function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
       $current_folder = dirname(__FILE__);
       
       // Build an array of paths segment names to be joins using OS specific slashes.
       $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
       
       // The DIRECTORY_SEPARATOR constant is OS specific.
       return join(DIRECTORY_SEPARATOR, $path_segments);
    }

    // file_is_an_image() - Checks the mime-type & extension of the uploaded file for "image-ness".
    function file_is_an_image($temporary_path, $new_path) {
        $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
        $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
        
        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
        $actual_mime_type        = getimagesize($temporary_path)['mime'];
        
        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
        
        return $file_extension_is_valid && $mime_type_is_valid;
    }
    
    
    $file_upload_detected = isset($_FILES['file']) && ($_FILES['file']['error'] === 0);
    $upload_error_detected = isset($_FILES['file']) && ($_FILES['file']['error'] > 0);
    if ($file_upload_detected) { 
        $file_name        = $_FILES['file']['name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_filename        = basename($file_name, '.' . $file_ext);
        $temporary_file_path  = $_FILES['file']['tmp_name'];
        $new_file_path        = file_upload_path($file_name);
        if (file_is_an_image($temporary_file_path, $new_file_path)) 
        {        
            $isValid = true;
            //includes ImageResize library    
            include 'resizeLibrary/ImageResize.php';

            //resizes and saves thumbnail version of submitted image
            $image = new \Gumlet\ImageResize($temporary_file_path);
            $image->resize(325,500);
            $image->save(file_upload_path($file_filename . '.' . $file_ext));

        }
        else
        {
            $isValid = false;
        }
    }

    // if Edit Book form is submitted
if(isset($_POST['editBook'])){
    if (isset($_SESSION['login'])) {
        
        $genre = $_POST['genre'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $released = $_POST['released'];
        $image = $_FILES['file']['name'];


        unset($_SESSION['editSuccess']);

        //ensure form fields are filled properly
        
        if (empty($title)) {
            array_push($errors, "Title is required");
        }
        if (empty($author)) {
            array_push($errors, "Author is required");
        }
        if (!$isValid) {
            array_push($errors, "Uploaded file is not a valid image");
        }
        

        //if there are no errors, save book to the database
        if (count($errors) == 0) {
            $query = "UPDATE book SET Title = '$title', Author = '$author', ReleaseYear = '$released', Genre = '$genre', DateEdited =CURRENT_TIMESTAMP WHERE ISBN = '$ISBN'";

            $statement = $db->prepare($query);
            $statement->execute();
            
            $_SESSION['editsuccess'] = "You created a new book.";

            header('location: fullPage.php?ISBN=' . $ISBN);
        }
    }
    else
    {
        array_push($errors, "You must be logged in first.");
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
  <?php if(!isset($_SESSION['login'])): ?>
  <br>
  <p  class="message">You must be logged in to use this page.</p>
  <p class="message">
        Already have an account? <a href="login.php">Log in</a>
  </p>
  <?php endif ?>
  <div class="header">Edit Book</div>
    <form class="form" method="post" action="editBook.php" enctype="multipart/form-data">
        <!-- errors -->
        <?php include('errors.php'); ?>
        <?php while($row = $statement->fetch()):?>
                
        <div class="input-group">
            <label for="genre">Genre:</label>
            <select id="genre" name="genre">
                <?php while($genreRow = $genreStatement->fetch()):?>
                    <?php if($genreRow['Genre'] != $currentGenre): ?>
                    <option value="<?= $genreRow['Genre'] ?>">
                      <?= $genreRow['Genre'] ?>
                    <?php else :?>    
                    <option value="<?= $genreRow['Genre'] ?>" selected="selected">
                      <?= $genreRow['Genre'] ?>
                    </option>
                    <?php endif ?>
                <?php endwhile ?> 
            </select> 
        </div>
        <div class="input-group">
            <label for="title">Title:</label>
            <?= '<input type="text" name="title" value="' . $row['Title'] . '">' ?>
        </div>
        <div class="input-group">
            <label for="author">Author:</label>
            <?= '<input type="text" name="author" value="' . $row['Author'] . '">' ?>
        </div>
        <div class="input-group">
            <label for="released">Release Year:</label>
           <?= '<input type="text" name="released" value="' . $row['ReleaseYear'] . '">' ?>
        </div>
        <div class="input-group">
            <button type="submit" id="editBook" name="editBook" class="btn">Edit Book </button>
        </div>
        <?php endwhile ?>
    </form>



</body>
</html>