<?php
$connection = new mysqli('sql103.epizy.com', 'epiz_21340352', '5OCWFlnOLfth', 'epiz_21340352_ceng388_web_project');
if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}
$connection->set_charset("utf8")
/*
$connection = mysqli_connect('localhost', 'root', '0393');
if (!$connection){
    die("Database Connection Failed</br></br>" . mysqli_error($connection));
}
$select_db = mysqli_select_db($connection, 'cotz_test');
if (!$select_db){
    die("Database Selection Failed</br></br>" . mysqli_error($connection));
}
*/
?>
