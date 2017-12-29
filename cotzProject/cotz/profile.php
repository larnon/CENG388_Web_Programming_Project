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
      ?>
    </div>
      <img src=<?php
                  if(file_exists($usernameOwn . "_pp.jpg")){
                    echo "\"";
                    echo $usernameOwn;
                    echo "_pp.jpg";
                    echo "\"";
                  }
                  else{
                    echo "\"/profile_pictures/default_pp.jpg\"";
                  }
                ?> alt="Profile Picture" style="float:left;width:300px;height:300px;">
      <form action="upload_pp.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="300000"/>
        <input name="uploadfile" type="file"/>
        <input type="submit" value="Upload Profile Picture" />
	  	</form>
			<form id="changePass" action="change_pass.php" method="POST">
				<input id="owner" type="hidden" name="owner" value=<?php print "\"$usernameOwn\"";?>>
				<input type="submit" name="submit" value="Change Password">
	  	</form>
      <form action="change_pass.php" method="POST">
				<input id="owner" type="hidden" name="owner" value=<?php print "\"$usernameOwn\"";?>>
				<input type="submit" name="submit" value="Change Password">
	  	</form>
		<!--</div>-->
</body>
</html>
