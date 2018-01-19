<?php
if (isset($_POST['username'])){
  function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    if ($max < 1) {
        throw new Exception('$keyspace must be at least two characters long');
    }
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
  }

  require 'db_connect.php';
  $username = $_POST['username'];
  $email = $_POST['email'];
  $query = "SELECT * FROM user_login WHERE username='$username' AND email='$email'";
  $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
  $count = mysqli_num_rows($result);
  if ($count == 1){
    $newPassword = random_str(5);
    $query2 = "UPDATE user_login SET password='$newPassword'
               WHERE username='$username'";
    $result2 = mysqli_query($connection, $query2) or die(mysqli_error($connection));
    $values = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$headers = "From: no-reply@nydus.epizy.com";
		$message = "New Password: $newPassword";
		$subject = "Password Reset";
		$resulty = mail($email,$subject,$message,$headers);
    if($resulty){
      echo "<script type='text/javascript'>alert('Your new password has been sent to your e-mail address.')</script>";
  		echo "<script> window.location.assign('index.html'); </script>";
    }
    else{
      echo "<script type='text/javascript'>alert('Something went wrong!')</script>";
  		echo "<script> window.location.assign('forgot_pass.html'); </script>";
    }
  }
  else{
    echo "<script type='text/javascript'>alert('No such user exists.')</script>";
		echo "<script> window.location.assign('forgot_pass.html'); </script>";

  }
}
else{
  die( header( 'location: /index.html' ) );
}
?>
