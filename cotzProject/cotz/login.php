<?php
session_start();
require '../db_connect.php';
if (isset($_POST['username']) and isset($_POST['password'])){
  $username = $_POST['username'];
	$password = $_POST['password'];
  $query = "SELECT * FROM user_login WHERE username='$username' and Password='$password'";

  $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
  $count = mysqli_num_rows($result);

  if ($count == 1){
		$_SESSION['usrNameOwn'] = $username;
		header('location: /profile.php');
		// echo "<script> window.location.assign('profile.php'); </script>";
  }
  else{
    echo "<script type='text/javascript'>alert('Invalid Login Credentials')</script>";
		echo "<script> window.location.assign('index.html'); </script>";
  }
}
else{
	die( header( 'location: /index.html' ) );
}
?>
