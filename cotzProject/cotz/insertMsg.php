<?php
if ( $_SERVER['REQUEST_METHOD']!='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
		die( header( 'location: /index.html' ) );
}

require '../db_connect.php';

$user = $_POST['owner'];

$msgString = $_POST['msgString'];
$msgStringProper = str_replace("'", "''", $msgString);
$query = "INSERT INTO msg_table (owner, messages, date_added, time_added)
          VALUES ('$user', '$msgStringProper', DATE(NOW()), CURTIME())";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
?>
