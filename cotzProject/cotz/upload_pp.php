<?php
session_start();
if (isset($_POST['uploadfile']) and isset($_SESSION['usrNameOwn'])){
  $filename = $_SESSION['usrNameOwn'] . "_pp.jpg";
  $filesize = $_FILES['uploadfile']['size'];
  $uploadFile = "../profile_pictures/" . $filename;
  if (move_uploaded_file($_FILES['picture_file']['tmp_name'],$uploadFile)){
    echo "<script type='text/javascript'>alert('Profile picture uploaded.')</script>";
	  echo "<script> window.location.assign('profile.php'); </script>";
  }
  else{
    echo "<script type='text/javascript'>alert('Error occured uploading picture.')</script>";
	  echo "<script> document.location.reload(false); </script>";
  }
}
else{
  die( header( 'location: /index.html' ) );
}
?>
