<?php
session_start();
if(!isset($_SESSION['usrNameOwn'])){
  die( header( 'location: /index.html' ) );
}
require 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Nydus Chat</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="centerHorizontal">
    <button class="button1" onclick="window.location.href='/profile.php'"> Profile </button>
    <button class="button1" onclick="window.location.href='/friend_list.php'"> Friend List </button>
    <button class="button1" onclick="window.location.href='/logout.php'"> Logout </button>
  </div>
  <div class="floatRight">
    <div class="centerHorizontal">
      <form action="add_block_or_friend.php" method="POST">
        <div class="centerHorizontal">
          <input class="input1" type="text" name="user" required placeholder="USERNAME">
          <input class="input1Inline" type="submit" name="addFriend" value="Add Friend">
          <input class="input1Inline" type="submit" name="blockUser" value="Block User">
        </div>
      </form>
    </div>
  </div>
  <div>
    <?php
      echo "<h1> Friend Requests </h1>";
      $usernameOwn = $_SESSION['usrNameOwn'];
      $query = "SELECT * FROM friend_list WHERE username2='$usernameOwn' AND accepted=0";
      $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
      $count = mysqli_num_rows($result);
      if ($count == 0){
        echo " <h3> No pending friend requests to show. </h3>";
      }
      else{
        echo "<ul>";
        while($friendRequest = mysqli_fetch_array($result, MYSQLI_ASSOC)){
          $requestSender = $friendRequest['username1'];
          echo "<li>
                  <span class=\"biggerFont\"> $requestSender </span>
                  <form style=\"display: inline;\" action=\"friend_request.php\" method=\"POST\">
                    <input class=\"inputSmall\" type=\"hidden\" name=\"friendToAccept\" value=\"$requestSender\">
                	  <input class=\"inputSmallInline\" type=\"submit\" name=\"accept\" value=\"Accept\">
                    <input class=\"inputSmallInline\" type=\"submit\" name=\"decline\" value=\"Decline\">
                  </form>
                </li>";
        }
        echo "</ul>";
      }
    ?>
  </div>
  <div>
    <?php
      echo " <h1> Friend List </h1>";
      $query = "SELECT * FROM friend_list WHERE (username1='$usernameOwn' OR username2='$usernameOwn') AND accepted=1";
  		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
  		$count = mysqli_num_rows($result);
  		if ($count == 0){
  		  echo "<h3> You do not have any friends yet. </h3>";
  		}
  		else{
      echo "<ul>";
      while($friend = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        if($friend['username1'] == $usernameOwn){
          $friendToTalk =  $friend['username2'];
        }
        else{
          $friendToTalk =  $friend['username1'];
        }
        $query2 = "SELECT * FROM msg_table WHERE (sender='$friendToTalk' AND receiver='$usernameOwn') AND seen=0";
    		$result2 = mysqli_query($connection, $query2) or die(mysqli_error($connection));
    		$count2 = mysqli_num_rows($result2);
    		if ($count2 == 0){
          echo "<li>
                  <span class=\"biggerFont\"> $friendToTalk </span>
                  <form style=\"display: inline-block;\" action=\"choose_friend.php\" method=\"POST\">
                    <input class=\"inputSmall\" type=\"hidden\" name=\"friendToTalk\" value=\"" . $friendToTalk . "\">
                    <input class=\"inputSmall\" type=\"submit\" name=\"talk\" value=\"TALK\">
                  </form>
                  <form style=\"display: inline-block;\" action=\"remove_friend.php\" method=\"POST\">
                    <input class=\"inputSmall\" type=\"hidden\" name=\"friendToRemove\" value=\"" . $friendToTalk . "\">
                    <input class=\"inputSmall\" type=\"submit\" name=\"remove\" value=\"REMOVE\">
                  </form>
                </li>";
    		}
        else{
          echo "<li>
                  <span class=\"biggerFont\"> $friendToTalk (!) </span>
                  <form style=\"display: inline-block;\" action=\"choose_friend.php\" method=\"POST\">
                    <input class=\"inputSmall\" type=\"hidden\" name=\"friendToTalk\" value=\"" . $friendToTalk . "\">
                    <input class=\"inputSmall\" type=\"submit\" name=\"talk\" value=\"TALK\">
                  </form>
                  <form style=\"display: inline-block;\" action=\"remove_friend.php\" method=\"POST\">
                    <input class=\"inputSmall\" type=\"hidden\" name=\"friendToRemove\" value=\"" . $friendToTalk . "\">
                    <input class=\"inputSmall\" type=\"submit\" name=\"remove\" value=\"REMOVE\">
                  </form>
                </li>";
        }
      }
      echo "</ul>";
      }
    ?>
  </div>
  <div>
    <?php
      echo " <h1> Block List </h1>";
      $query = "SELECT * FROM block_list WHERE username1='$usernameOwn'";
  		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
  		$count = mysqli_num_rows($result);
  		if ($count == 0){
  		  echo "<h3> You do not have any blocked users. </h3>";
  		}
  		else{
        echo "<ul>";
        while($blocked = mysqli_fetch_array($result, MYSQLI_ASSOC)){
          $blockedUser =  $blocked['username2'];
          echo "<li>
                  <span class=\"biggerFont\"> $blockedUser </span>
                  <form style=\"display: inline-block;\" action=\"remove_block.php\" method=\"POST\">
                    <input class=\"inputSmall\" type=\"hidden\" name=\"userToRemoveBlock\" value=\"" . $blockedUser . "\">
                    <input class=\"inputSmallInline\" type=\"submit\" name=\"remove\" value=\"REMOVE\">
                  </form>
                </li>";
        }
        echo "</ul>";
      }
    ?>
  </div>
</body>
</html>
