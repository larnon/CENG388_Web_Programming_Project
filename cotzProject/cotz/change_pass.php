<?php
if ( $_SERVER['REQUEST_METHOD']!='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
		die( header( 'location: /index.html' ) );
}
?>

<?php
  if ( isset($_POST['submit2'])){ // Was the form submitted?
    require '../db_connect.php';
    $username = $_POST['owner2'];
		$newPass = $_POST['newPass'];
    $query = "UPDATE user_login
    					SET password = '$newPass'
              WHERE username = '$username'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		echo "<script type='text/javascript'>alert('You have changed your password successfully. You have to login again with your new password.')</script>";
		echo "<script> window.location.assign('index.html'); </script>";
    //header( 'location: /index.html' );
  }
  else{
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    	<meta charset="utf-8">
    	<title>Cotz v0.1</title>
    	<link rel="stylesheet" href="style.css">
    </head>
    <body>
      <div id="index">
        <form id="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" accept-charset="utf-8">
          <input type="hidden" name="owner2" value=<?php $username2 = $_POST['owner']; print "\"$username2\"";?>>
          <input type="text" name="newPass" required placeholder="Enter New Password">
          <input type="submit" name="submit2" value="Change">
        </form>
        </br>
        All white spaces in either side of the password will be trimmed.</br>
        If you only enter whitespaces, you will end up with a blank password.</br>
      </div>
    </body>
    </html>
<?php } ?>
