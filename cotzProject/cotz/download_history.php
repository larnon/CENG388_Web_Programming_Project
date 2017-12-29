<?php
if ( $_SERVER['REQUEST_METHOD']!='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
		header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
		die( header( 'location: /index.html' ) );
}

session_start();

require '../db_connect.php';

$usernameOwn = $_POST['usrNameOwn'];
$usernameOther = $_POST['usrNameOther'];

header('Cache-Control: public');
header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename=history.txt');
header('Content-Type: text/plain; charset=utf-8');
header('Content-Transfer-Encoding: binary');
$queryAllMsgs = "SELECT date_added, time_added, messages, owner
                  FROM msg_table
                  WHERE (sender = \'$usernameOwn\' AND receiver = \'$usernameOther\') OR (sender = \'$usernameOther\' AND receiver = \'$usernameOwn\')
                  ORDER by date_added DESC, time_added DESC";
$AllMsgs = mysqli_query($connection, $queryAllMsgs) or die(mysqli_error($connection));
while($row1 = mysqli_fetch_array($AllMsgs,MYSQLI_ASSOC)){
  echo $row1["date_added"] . " / " . $row1["time_added"] . " - " . $row1["owner"] . ":\r\n" .
          $row1["messages"] . "\n\r\n\r\n\r-----------------------------------\n\r\n\r\n\r";
}
?>
