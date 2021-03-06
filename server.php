<?php
	session_start();

	require('connect.php');

	$username = "";
	$email = "";
	$password = "";
	$errors = array();

	if (!isset($_SESSION['login'])) {
		$_SESSION['UserType'] = "0";
	}

 // if register button is clicked
if(isset($_POST['register'])){

 	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
 	if (filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL) && isset($_POST['email'])) {
 		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
 	}
 	else
 	{
 		array_push($errors, "Please enter a valid email");
 	}
 	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
 	$confirmPassword = filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

 	//ensure form fields are filled properly
 	if (empty($username)) {
 		array_push($errors, "Username is required");
	}
	if (empty($email)) {
 		array_push($errors, "Email is required");
	}
	if (empty($password)) {
 		array_push($errors, "Password is required");
	}
	if($password != $confirmPassword) {
		array_push($errors, "Passwords do not match");
	}

	//if there are no errors, save user to the database
	if (count($errors) == 0) {
		// encrypt password before storing in database
		$password = password_hash($password, PASSWORD_DEFAULT);
		$query = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";

		$statement = $db->prepare($query);
  		$statement->execute();

  		$_SESSION['username'] = $username;



  		
		
		$subject = "Welcome";
		$txt = "Hello" . $username . ". Thanks for registering an account with Bookishly!";
		$headers = "From: webmaster@bookishly.com";		
		mail($email,$subject,$txt,$headers);

  		header('location: index.php');
		}
}


// user login from login page
if (isset($_POST['login'])) {
	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
 	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


 	//ensure form fields are filled properly
 	if (empty($username)) {
 		array_push($errors, "Username is required");
	}
	if (empty($password)) {
 		array_push($errors, "Password is required");
	}

	if (count($errors) == 0 ) {
		
		$query = "SELECT * FROM user WHERE username = '$username'";

		$loginStatement = $db->prepare($query);
  		$loginStatement->execute();
  		

		if ($loginStatement->rowCount() == 1) {
			$row = $loginStatement->fetch();
			$hash = $row['Password'];
			if(password_verify($password, $hash))
			{
				//log user in
				$_SESSION['username'] = $username;
				$_SESSION['login'] = 1;				
	  			$_SESSION['success'] = "You are now logged in";
	  			$_SESSION['UserId'] = $row['UserId'];
	  			$_SESSION['UserType'] = $row['UserType'];
	  			header('location: index.php');
			} else {
				array_push($errors, "Invalid username or password");
						

			}
			
		}
	}
}

// logout

if (isset($_GET['logout'])) {
	unset($_SESSION['username']);
	unset($_SESSION['login']);
	unset($_SESSION['UserType']);
	session_destroy();
	header('location: login.php');
}





?>