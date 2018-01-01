<?php
session_start();
if(!isset($_SESSION['usrNameOwn']) and !isset($_POST['talk'])){
  die( header( 'location: /index.html' ) );
}
$_SESSION['friendToTalk'] = $_POST['friendToTalk'];
header( 'location: /talk.php' );
?>
