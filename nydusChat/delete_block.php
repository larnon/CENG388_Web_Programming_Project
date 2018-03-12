<?php
session_start();
if(!isset($_SESSION['usrNameOwn']) or !isset($_POST['userToDeleteBlock'])){
  die( header( 'location: /index.html' ) );
}
else{
  require 'db_connect.php';
  $userToDeleteBlock = $_POST['userToDeleteBlock'];
  $usernameOwn = $_SESSION['usrNameOwn'];
  if(isset($_POST['accept'])){
    $query = "DELETE FROM block_list
              WHERE username2='$userToDeleteBlock' AND username1='$usernameOwn'";
    $result1 = mysqli_query($connection, $query) or die(mysqli_error($connection));
    if($result1){
      echo "<script type='text/javascript'>alert('Block removed!')</script>";
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
