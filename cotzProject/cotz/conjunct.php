<?php
if ( $_SERVER['REQUEST_METHOD']!='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
		die( header( 'location: /index.html' ) );
}

require '../db_connect.php';
$query = "UPDATE msg_table
					SET conjucted = 1";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
//header( 'location: /index.html' )
?>
