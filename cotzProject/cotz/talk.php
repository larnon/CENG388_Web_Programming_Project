<?php
if ( $_SERVER['REQUEST_METHOD']!='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
		header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
		die( header( 'location: /index.html' ) );
}

session_start();

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
  <div id="page-wrapper-login">
    <div id="text1">
    	<?php
       $usernameOwn = $_SESSION['usrNameOwn'];
			 $usernameOther = $_SESSION['usrNameOther'];
      ?>
    </div>
			<form id="changePass" action="change_pass.php" method="POST">
				<input id="owner" type="hidden" name="owner" value=<?php print "\"$usernameOwn\"";?>>
				<input type="submit" name="submit" value="Change Password">
	  	</form>
			<script>
				$(document).ready(function(){
			    $('#msgButton').click(function(){
			      if($('#msg').val().trim().length < 1){
							$('#msg').val('');
			        alert("Can not send empty message!");
			     	}
						else{
							$.ajax({
			            url: 'insertMsg.php',
			            type: 'POST', // GET or POST
			            data: jQuery("#msgForm").serialize(),// will be in $_POST on PHP side
			            success: function(data) { // data is the response from your php script
			                // This function is called if your AJAX query was successful
											location.reload(true);
			            },
			            error: function() {
			                // This callback is called if your AJAX query has failed
			                alert("Error!");
			            }
			        });
						}
			    });
				});
			</script>
  	<form id="msgForm" method="POST">
  		<textarea id="msg" name="msgString" placeholder="Please write to me ;_;" required rows="20" cols="100" maxlength="9999"></textarea>
  		</br>
			<input id="owner" type="hidden" name="owner" value=<?php print "\"$usernameOwn\"";?>>
			<button id="msgButton" type="button">Send Message</button>
  	</form>
		</div>
		<div id="page-wrapper-login">
			<button id="refresh" type="submit" onclick="refresh()"> REFRESH </button>
		</div>
		<table id="messageTable" style="width:100%;">
		  <tr>
		    <th>RECEIVED</th>
		    <th>SENT</th>
		  </tr>
		  <tr>
		    <td colspan="2">
					<?php
					$queryMsgs = "SELECT date_added, time_added, message, sender, receiver
														FROM msg_table
														WHERE (sender = \'$usernameOwn\' AND receiver = \'$usernameOther\') OR (sender = \'$usernameOther\' AND receiver = \'$usernameOwn\')
														ORDER by date_added DESC, time_added DESC
														LIMIT 50";
				  $Msgs = mysqli_query($connection, $queryMsgs) or die(mysqli_error($connection));
					while($row = mysqli_fetch_array($Msgs,MYSQLI_ASSOC)){
						$correctMessage = str_replace("\r\n", "</br>", $row["messages"]);
						$correctMessage = chunk_split($correctMessage, 100, "</br>");
						if($row["owner"] == $usernameOwn){
							print "<p style=\"text-align:right; text-justify:inter-word\">" . $row["date_added"] . " / " . $row["time_added"] . " - " . $row["owner"] . "</br></br>" .
											$correctMessage . "</br></br></br></p>";
						}
						else{
							print "<p style=\"text-align:left; text-justify:inter-word\">" . $row["date_added"] . " / " . $row["time_added"] . " - " . $row["owner"] . "</br></br>" .
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
