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
  <!--<div id="page-wrapper-login">-->
    <div id="text1">
    	<?php
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
    </div>
			<form action="add_friend.php" method="POST">
        <input type="text" name="username" required placeholder="USERNAME">
				<input type="submit" name="submit" value="Add Friend">
	  	</form>
		<!--</div>-->
</body>
</html>
