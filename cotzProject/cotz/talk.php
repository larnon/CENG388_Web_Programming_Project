<?php
session_start();
if(!isset($_SESSION['usrNameOwn'])){
  die( header( 'location: /index.html' ) );
}
elseif(!isset($_SESSION['friendToTalk'])){
  header( 'location: /profile.php' );
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
  <div id="page-wrapper-login">
    <div id="text1">
    	<?php
       $usernameOwn = $_SESSION['usrNameOwn'];
			 $usernameOther = $_SESSION['friendToTalk'];
      ?>
    </div>
  	<form id="msgForm" action="insertMsg.php" method="POST">
  		<textarea id="msg" name="msgString" placeholder="Write your message here..." required rows="10" cols="100" maxlength="9999"></textarea>
  		</br>
			<input id="owner" type="hidden" name="receiver" value=<?php print "\"$usernameOther\"";?>>
			<input type="submit" name="sendMsg" value="Send Message">
  	</form>
		</div>
		<table id="messageTable" style="width:100%;">
		  <tr>
		    <th> <img src=<?php echo "\"profile_pictures/" . $usernameOther . "_pp.jpg\"";?> alt="Profile Picture" style="width:150px;height:150px;"> </th>
				<th> <img src=<?php echo "\"profile_pictures/" . $usernameOwn . "_pp.jpg\"";?> alt="Profile Picture" style="width:150px;height:150px;"> </th>
		  </tr>
		  <tr>
		    <td colspan="2">
					<?php
					$queryMsgs = "SELECT date_added, time_added, message, sender, receiver
														FROM msg_table
														WHERE (sender = '$usernameOwn' AND receiver = '$usernameOther') OR (sender = '$usernameOther' AND receiver = '$usernameOwn')
														ORDER by date_added DESC, time_added DESC
														LIMIT 50";
				  $Msgs = mysqli_query($connection, $queryMsgs) or die(mysqli_error($connection));
					while($row = mysqli_fetch_array($Msgs,MYSQLI_ASSOC)){
						$correctMessage = str_replace("\r\n", "</br>", $row["message"]);
						$correctMessage = chunk_split($correctMessage, 100, "</br>");
						if($row["sender"] == $usernameOwn){
							print "<p style=\"text-align:right; text-justify:inter-word\">" . $row["date_added"] . " / " . $row["time_added"] . " - " . $row["sender"] . "</br></br>" .
											$correctMessage . "</br></br></br></p>";
						}
						else{
							print "<p style=\"text-align:left; text-justify:inter-word\">" . $row["date_added"] . " / " . $row["time_added"] . " - " . $row["sender"] . "</br></br>" .
											$correctMessage . "</br></br></br></p>";
						}

					}
				 ?>
			  </td>
		  </tr>
		</table>
		<div id="page-wrapper-login">
			<form id="msgForm" action="download_history.php" method="POST">
				<input type="hidden" name="usrNameOwn" value=<?php print "\"$usernameOwn\"";?>>
				<input type="hidden" name="usrNameOther" value=<?php print "\"$usernameOther\"";?>>
			  <input type="submit" value="Download Message History">
			</form>
		</div>
</body>
</html>
