<?php
	
	include('server.php');

	$genreQuery = "SELECT * FROM genre";

  $genreStatement = $db->prepare($genreQuery);
  $genreStatement->execute();

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
    
    $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
    $upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);

    if ($image_upload_detected) { 
        $image_filename        = $_FILES['image']['name'];
        $temporary_image_path  = $_FILES['image']['tmp_name'];
        $new_image_path        = file_upload_path($image_filename);
        if (file_is_an_image($temporary_image_path, $new_image_path)) {
            move_uploaded_file($temporary_image_path, $new_image_path);
        }
    }

    // if New Book form is submitted
if(isset($_POST['newBook'])){
 	$isbn = $_POST['isbn'];
 	$genre = $_POST['genre'];
 	$title = $_POST['title'];
 	$author = $_POST['author'];
 	$released = $_POST['released'];
 	$image = $_FILES['image']['name'];

 	unset($_SESSION['bookSuccess']);

 	//ensure form fields are filled properly
 	if (empty($isbn)) {
 		array_push($errors, "ISBN is required");
	}
	if (empty($title)) {
 		array_push($errors, "Title is required");
	}
	

	//if there are no errors, save book to the database
	if (count($errors) == 0) {
		$query = "INSERT INTO book (ISBN, Title, Author, ReleaseYear, Genre, CoverImg) VALUES ('$isbn', '$title', '$author', '$released', '$genre', '$image')";

		$statement = $db->prepare($query);
  		$statement->execute();
  		
  		$_SESSION['success'] = "You created a new book.";

  		header('location: index.php');
	}

}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Submit Book</title>
	<link rel="stylesheet" type="text/css" href="formstyle.css">
</head>
	<div class="header">Submit Book</div>
<body>
	<form method="post" action="newBook.php" enctype="multipart/form-data">
		<!-- errors -->
		<?php include('errors.php'); ?>
		<div class="input-group">
			<label for="image">Cover Image:</label>
			<input type="file" id="image" name="image">
		</div>
		<div class="input-group">
			<label for="isbn">ISBN:</label>
			<input type="number" id="isbn" name="isbn">
		</div>
		<div class="input-group">
			<label for="genre">Genre:</label>
			<select id="genre" name="genre">
				<?php while($row = $genreStatement->fetch()):?>
                    <option value="<?= $row['Genre'] ?>">
                      <?= $row['Genre'] ?>
                    </option>
                <?php endwhile ?> 
			</select> 
		</div>
		<div class="input-group">
			<label for="title">Title:</label>
			<input type="text" id="title" name="title">
		</div>
		<div class="input-group">
			<label for="author">Author:</label>
			<input type="text" id="author" name="author">
		</div>
		<div class="input-group">
			<label for="released">Release Year:</label>
			<input type="text" id="released" name="released">
		</div>
		<div class="input-group">
			<button type="submit" id="newBook" name="newBook" class="btn">Submit Book </button>
		</div>
		<p>
			Already have an account? <a href="login.php">Log in</a>
		</p>

	</form>



</body>
</html>
