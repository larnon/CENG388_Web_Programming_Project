<?php
session_start();
if(!isset($_SESSION['usrNameOwn']) or !isset($_POST['friendToAccept'])){
  die( header( 'location: /index.html' ) );
}
else{
  require 'db_connect.php';
  $friendToAccept = $_POST['friendToAccept'];
  $usernameOwn = $_SESSION['usrNameOwn'];
  if(isset($_POST['accept'])){
    $query = "UPDATE friend_list
    					SET accepted = 1
              WHERE username1='$friendToAccept' AND username2='$usernameOwn' AND accepted = 0";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    if($result){
      echo "<script type='text/javascript'>alert('Friend request accepted!')</script>";
  		echo "<script> window.location.assign('friend_list.php'); </script>";
    }
    else{
      echo "<script type='text/javascript'>alert('Something went wrong!')</script>";
  		echo "<script> window.location.assign('friend_list.php'); </script>";
    }
  }
  else{
    $query = "DELETE FROM friend_list
              WHERE username1='$friendToAccept' AND username2='$usernameOwn' AND accepted = 0";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    if($result){
      echo "<script type='text/javascript'>alert('Friend request declined!')</script>";
  		echo "<script> window.location.assign('friend_list.php'); </script>";
    }
    else{
      echo "<script type='text/javascript'>alert('Something went wrong!')</script>";
  		echo "<script> window.location.assign('friend_list.php'); </script>";
    }
  }
}
?>
