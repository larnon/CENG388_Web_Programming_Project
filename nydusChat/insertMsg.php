<?php
session_start();
if(!isset($_SESSION['usrNameOwn']) and !isset($_POST['sendMsg'])){
  die( header( 'location: /index.html' ) );
}
require 'db_connect.php';

$sender = $_SESSION['usrNameOwn'];
$receiver = $_POST['receiver'];
$msgString = $_POST['msgString'];
$msgStringProper = str_replace("'", "''", $msgString);

$query = "INSERT INTO msg_table (sender, receiver, message, date_added, time_added)
          VALUES ('$sender', '$receiver', '$msgStringProper', DATE(NOW()), CURTIME())";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
header( 'location: /talk.php' );
?>
