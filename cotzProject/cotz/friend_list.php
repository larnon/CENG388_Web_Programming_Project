<?php
session_start();
if(!isset($_SESSION['usrNameOwn'])){
  die( header( 'location: /index.html' ) );
}
require '../db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Cotz v0.1</title>
	<link rel="stylesheet" href="style.css">
	<script type="text/javascript">
	    function refreshPage() {
	        var page_y = document.getElementsByTagName("body")[0].scrollTop;
	        window.location.href = window.location.href.split('?')[0] + '?page_y=' + page_y;
	    }
	    window.onload = function () {
	        //setTimeout(refreshPage, 35000);
	        if ( window.location.href.indexOf('page_y') != -1 ) {
	            var match = window.location.href.split('?')[1].split("&")[0].split("=");
	            document.getElementsByTagName("body")[0].scrollTop = match[1];
	        }
	    }
	</script>
</head>
<body>
  <a href="profile.php "> Profile </a>
  <a href="friend_list.php "> Friend List </a>
  <a href="talk.php "> Last Chat </a>
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
                  <form action=\"friend_request.php\" method=\"POST\">
                    <input type=\"hidden\" name=\"friendToAccept\" value=\"$requestSender\">
                    <h3> $requestSender </h3>
                  	<input type=\"submit\" name=\"accept\" value=\"Accept\">
                    <input type=\"submit\" name=\"decline\" value=\"Decline\">
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
          echo "<li>
                  <form action=\"choose_friend.php\" method=\"POST\">
                    <input type=\"hidden\" name=\"friendToTalk\" value=\"" . $friendToTalk . "\">
                    <h3> $friend[username2] </h3>
                    <input type=\"submit\" name=\"talk\" value=\"TALK\">
                  </form>
                </li>";
        }
        else{
          $friendToTalk =  $friend['username1'];
          echo "<li>
                  <form action=\"choose_friend.php\" method=\"POST\">
                    <input type=\"hidden\" name=\"friendToTalk\" value=\"" . $friendToTalk . "\">
                    <h3> $friend[username1] </h3>
                    <input type=\"submit\" name=\"talk\" value=\"TALK\">
                  </form>
                </li>";
        }
      }
      echo "</ul>";
      }
    ?>
  </div>
  <form action="add_friend.php" method="POST">
    <input type="text" name="friend" required placeholder="USERNAME">
  	<input type="submit" name="submit" value="Add Friend">
  </form>
</body>
</html>
