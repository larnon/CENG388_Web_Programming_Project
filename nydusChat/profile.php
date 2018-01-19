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
  <?php
   $usernameOwn = $_SESSION['usrNameOwn'];
  ?>
  <div class="centerHorizontal">
    <button class="button1" onclick="window.location.href='/profile.php'"> Profile </button>
    <button class="button1" onclick="window.location.href='/friend_list.php'"> Friend List </button>
    <button class="button1" onclick="window.location.href='/logout.php'"> Logout </button>
  </div>
  <div class="center">
    <h1> Welcome <?php print "$usernameOwn"; ?>! </h1>
    <img src=<?php
                if(file_exists("profile_pictures/" . $usernameOwn . "_pp.jpg")){
                  echo "\"";
                  echo "profile_pictures/";
                  echo $usernameOwn;
                  echo "_pp.jpg";
                  echo "\"";
                }
                else{
                  echo "\"/profile_pictures/default_pp.jpg\"";
                }
              ?> alt="Profile Picture" style="width:300px;height:300px;">
    <form action="upload_pp.php" method="POST" enctype="multipart/form-data">
      <div class="center">
        <input style="color: transparent;width: 240px;
    overflow:hidden;" class="input1" name="uploadfile" type="file" required />
        <input class="input1" type="submit" value="Upload Profile Picture" />
      </div>
    </form>
    <form action="change_pass.php" method="POST">
      <div class="center">
    	   <input class="input1" type="hidden" name="owner" value=<?php print "\"$usernameOwn\"";?>>
    	   <input class="input1" type="submit" name="submit" value="Change Password">
      </div>
    </form>
  </div>
</body>
</html>
