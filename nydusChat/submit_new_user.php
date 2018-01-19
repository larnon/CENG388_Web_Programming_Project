<?php
if (isset($_POST['email']) and isset($_POST['username']) and isset($_POST['password1']) and isset($_POST['password2'])){
	require 'db_connect.php';

	$email = trim($_POST['email']);
	$username = trim($_POST['username']);
	$password1 = trim($_POST['password1']);
	$password2 = trim($_POST['password2']);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "<script type='text/javascript'>alert('Not a proper e-mail address.')</script>";
	  echo "<script> window.location.assign('register.html'); </script>";
	}
	elseif($email == "" or $username == "" or $password1 == "" or $password2 == "" or $password1 != $password2){
	  echo "<script type='text/javascript'>alert('Improper value detected. Please check your inputs.')</script>";
	  echo "<script> window.location.assign('register.html'); </script>";
	}
	elseif($password1 != $password2){
	  echo "<script type='text/javascript'>alert('Passwords do not match.')</script>";
	  echo "<script> window.location.assign('register.html'); </script>";
	}
	else{
		$query = "SELECT * FROM user_login WHERE username='$username' OR email='$email'";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		$count = mysqli_num_rows($result);
		if ($count > 0){
		  echo "<script type='text/javascript'>alert('Username or email already in use.')</script>";
		  echo "<script> window.location.assign('register.html'); </script>";
		}
		else{
			$query = "INSERT INTO user_login (username, password, email)
			          VALUES ('$username', '$password1', '$email')";
			mysqli_query($connection, $query) or die(mysqli_error($connection));
			echo "<script type='text/javascript'>alert('Registered successfully!')</script>";
			echo "<script> window.location.assign('index.html'); </script>";
		}
	}
}
else{
	die( header( 'location: /index.html' ) );
}
?>
