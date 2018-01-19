<?php
session_start();
if(!isset($_SESSION['usrNameOwn'])){
  die( header( 'location: /index.html' ) );
}
$username = $_SESSION['usrNameOwn'];
$today = date("Ymd");
$logFile = fopen($today . ".txt", "a") or die("Unable to open the log file!");
$time = date("h:i:s");
fwrite($logFile, "\r\n");
$log = "$time - User logged out: $username\r\n";
fwrite($logFile, $log);
fclose($logFile);
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  <meta http-equiv="refresh" content="5; url=/index.html" />
	<title>Nydus Chat</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="centerAbs">
		<h1> You are logged out successfully, redirecting back to login page... </h1>
	</div>
</body>
</html>
