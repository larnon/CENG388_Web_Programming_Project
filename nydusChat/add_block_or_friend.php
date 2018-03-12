<?php
session_start();
if(!isset($_SESSION['usrNameOwn']) or !isset($_POST['user'])){
  die( header( 'location: /index.html' ) );
}
elseif(isset($_POST['blockUser'])){
  if($_SESSION['usrNameOwn'] == $_POST['user']){
    echo "<script type='text/javascript'>alert('You can not block yourself!')</script>";
    echo "<script> window.location.assign('friend_list.php'); </script>";
  }
  else{
    require 'db_connect.php';
    $userToBlock = $_POST['user'];
    $usernameOwn = $_SESSION['usrNameOwn'];
    $query = "SELECT * FROM user_login WHERE username = '$userToBlock'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    $count = mysqli_num_rows($result);
    if ($count == 0){
      echo "<script type='text/javascript'>alert('No such user exists.')</script>";
  		echo "<script> window.location.assign('friend_list.php'); </script>";
    }
    else{
      $query = "SELECT * FROM block_list WHERE username1 = '$usernameOwn' AND username2 = '$userToBlock'";
      $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
      $count = mysqli_num_rows($result);
      if ($count > 0){
        echo "<script type='text/javascript'>alert('You have already blocked this user!')</script>";
    		echo "<script> window.location.assign('friend_list.php'); </script>";
      }
      else{
        $query = "SELECT * FROM friend_list WHERE (username1 = '$usernameOwn' AND username2 = '$userToBlock')
                                                                                         OR
                                                  (username2 = '$usernameOwn' AND username1 = '$userToBlock')";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
        $count = mysqli_num_rows($result);
        if ($count > 0){
          echo "<script type='text/javascript'>alert('You have to remove your friend first!')</script>";
      		echo "<script> window.location.assign('friend_list.php'); </script>";
        }
        else{
          $query = "INSERT INTO block_list (username1, username2)
    			          VALUES ('$usernameOwn', '$userToBlock')";
    			mysqli_query($connection, $query) or die(mysqli_error($connection));
    			echo "<script type='text/javascript'>alert('User blocked!')</script>";
    			echo "<script> window.location.assign('friend_list.php'); </script>";
        }
      }
    }
  }
}
else{
  if($_SESSION['usrNameOwn'] == $_POST['user']){
    echo "<script type='text/javascript'>alert('You can not add yourself as a friend!')</script>";
    echo "<script> window.location.assign('friend_list.php'); </script>";
  }
  else{
    require 'db_connect.php';
    $friendToAdd = $_POST['user'];
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
        $query = "SELECT * FROM block_list WHERE (username1 = '$usernameOwn' AND username2 = '$friendToAdd')
                                                                                         OR
                                                  (username2 = '$usernameOwn' AND username1 = '$friendToAdd')";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
        $count = mysqli_num_rows($result);
        if ($count > 0){
          echo "<script type='text/javascript'>alert('At least one of you has blocked the other!')</script>";
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
}
?>
