<?php
session_start();
if(!isset($_SESSION['usrNameOwn'])){
  die( header( 'location: /index.html' ) );
}
if ( isset($_POST['submit2'])){ // Was the form submitted?
  require 'db_connect.php';
  $username = $_SESSION['usrNameOwn'];
	$newPass1 = trim($_POST['newPass1']);
	$newPass2 = trim($_POST['newPass2']);
	if($newPass1 != $newPass2){
		echo "<script type='text/javascript'>alert('Passwords do not match!')</script>";
		echo "<script> location.assign('profile.php'); </script>";
	}
	elseif($newPass1 == ""){
		echo "<script type='text/javascript'>alert('Password can not be blank!')</script>";
		echo "<script> location.assign('profile.php'); </script>";
	}
	else{
		$query = "UPDATE user_login
	  					SET password = '$newPass1'
	            WHERE username = '$username'";
	  $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		if($result){
			echo "<script type='text/javascript'>alert('You have changed your password successfully. You have to login again with your new password.')</script>";
			echo "<script> window.location.assign('index.html'); </script>";
		}
	}

}
else{
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
      <div class="center">
				<h1> Change your password </h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" accept-charset="utf-8">
					<div class="center">
          	<input class="input1" type="text" name="newPass1" required placeholder="Password">
						<input class="input1" type="text" name="newPass2" required placeholder="Password">
          	<input class="input1" type="submit" name="submit2" value="Change">
					</div>
        </form>
      </div>
    </body>
    </html>
<?php } ?>
