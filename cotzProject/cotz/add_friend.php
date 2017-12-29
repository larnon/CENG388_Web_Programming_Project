<?php
session_start();
if(!isset($_SESSION['usrNameOwn'])){
  die( header( 'location: /index.html' ) );
}
require '../db_connect.php';

$usernameOwn = $_SESSION['usrNameOwn'];

$query = "SELECT * FROM friend_list WHERE username1='$usernameOwn' OR username2='$usernameOwn'";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
$count = mysqli_num_rows($result);
if ($count == 0){
  echo " <h3> You do not have any friends yet. </h3>";
}
else{
	$query = "INSERT INTO user_login (username, password, email)
	          VALUES ('$username', '$password1', '$email')";
	$friends = mysqli_query($connection, $query) or die(mysqli_error($connection));
echo "<ul>";
while($friend = mysqli_fetch_array($friends, MYSQLI_ASSOC)){
  if($friend['username1'] == $usernameOwn){
    echo "<li> $friend[username2] </li>";
  }
  else{
    echo "<li> $friend[username1] </li>";
  }
}
echo "</ul>";
?>
