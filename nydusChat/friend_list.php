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
  <div>
    <?php
      echo " <h2> Friend Requests </h2>";
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
                  $requestSender
                  <form style=\"display: inline-block;\" action=\"friend_request.php\" method=\"POST\">
                    <input class=\"inputSmall\" type=\"hidden\" name=\"friendToAccept\" value=\"$requestSender\">
                	  <input class=\"inputSmall\" type=\"submit\" name=\"accept\" value=\"Accept\">
                    <input class=\"inputSmall\" type=\"submit\" name=\"decline\" value=\"Decline\">
                  </form>
                </li>";
        }
        echo "</ul>";
      }
    ?>
  </div>
  <div>
    <?php
      echo " <h2> Friend List </h2>";
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
        echo "<li>
                $friendToTalk
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
      echo "</ul>";
      }
    ?>
  </div>
  <form action="add_friend.php" method="POST">
    <div class="center">
      <input class="input1" type="text" name="friend" required placeholder="USERNAME">
    	<input class="input1" type="submit" name="submit" value="Add Friend">
    </div>
  </form>
</body>
</html>
