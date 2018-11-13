<?php
	session_start();

	require('connect.php');

	$username = "";
	$email = "";
	$password = "";
	$errors = array();

 // if register button is clicked
	if(isset($_POST['register'])){
 	$username = $_POST['username'];
 	$email = $_POST['email'];
 	$password = $_POST['password'];
 	$confirmPassword = $_POST['confirmPassword'];

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
  		$_SESSION['login'] = 1;
  		$_SESSION['success'] = "You are now logged in";
  		header('location: index.php');
		}
	}

// user login from login page
if (isset($_POST['login'])) {
	$username = $_POST['username'];
 	$password = $_POST['password'];

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
	  			header('location: index.php');
			} else {
				array_push($errors, "Invalid username or password");
				echo $row['Password'];
				echo $password;			

			}
			
		}
	}
}

// logout

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
	unset($_SESSION['login']);
	header('location: login.php');
}





?>