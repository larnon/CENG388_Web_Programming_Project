<?php
session_start();
if(!isset($_SESSION['usrNameOwn']) or !isset($_POST['friend'])){
  die( header( 'location: /index.html' ) );
}
else{
  if($_SESSION['usrNameOwn'] == $_POST['friend']){
    echo "<script type='text/javascript'>alert('You can not add yourself as a friend!')</script>";
    echo "<script> window.location.assign('friend_list.php'); </script>";
  }
  else{
    require '../db_connect.php';
    $friendToAdd = $_POST['friend'];
    $usernameOwn = $_SESSION['usrNameOwn'];
    $query = "SELECT * FROM user_login WHERE username = '$friendToAdd'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    $count = mysqli_num_rows($result);
    if ($count == 0){
      echo "<script type='text/javascript'>alert('No such user exists.')</script>";
  		echo "<script> window.location.assign('friend_list.php'); </script>";
    }
    else{
      $query = "SELECT * FROM friend_list WHERE (username1 = '$usernameOwn' AND username2 = '$friendToAdd')
                                                                                       OR
                                                (username2 = '$usernameOwn' AND username1 = '$friendToAdd')";
      $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
      $count = mysqli_num_rows($result);
      if ($count > 0){
        echo "<script type='text/javascript'>alert('You have already added each other as friends!')</script>";
    		echo "<script> window.location.assign('friend_list.php'); </script>";
      }
      else{
        $query = "INSERT INTO friend_list (username1, username2, accepted)
  			          VALUES ('$usernameOwn', '$friendToAdd', 0)";
  			mysqli_query($connection, $query) or die(mysqli_error($connection));
  			echo "<script type='text/javascript'>alert('Friend request sent!')</script>";
  			echo "<script> window.location.assign('friend_list.php'); </script>";
      }
    }
  }
}
?>
