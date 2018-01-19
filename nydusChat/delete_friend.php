<?php
session_start();
if(!isset($_SESSION['usrNameOwn']) or !isset($_POST['friendToDelete'])){
  die( header( 'location: /index.html' ) );
}
else{
  require 'db_connect.php';
  $friendToDelete = $_POST['friendToDelete'];
  $usernameOwn = $_SESSION['usrNameOwn'];
  if(isset($_POST['accept'])){
    $query = "DELETE FROM friend_list
              WHERE username1='$friendToDelete' AND username2='$usernameOwn' OR username2='$friendToDelete' AND username1='$usernameOwn'";
    $result1 = mysqli_query($connection, $query) or die(mysqli_error($connection));
    $query = "DELETE FROM msg_table
              WHERE sender='$friendToDelete' AND receiver='$usernameOwn' OR receiver='$friendToDelete' AND sender='$usernameOwn'";
    $result2 = mysqli_query($connection, $query) or die(mysqli_error($connection));
    if($result1 && $result2){
      echo "<script type='text/javascript'>alert('Friend deleted!')</script>";
  		echo "<script> window.location.assign('friend_list.php'); </script>";
    }
    else{
      echo "<script type='text/javascript'>alert('Something went wrong!')</script>";
  		echo "<script> window.location.assign('friend_list.php'); </script>";
    }
  }
  else{
    echo "<script> window.location.assign('friend_list.php'); </script>";
  }
}
?>
