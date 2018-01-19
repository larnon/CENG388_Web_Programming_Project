<?php
session_start();
if(!isset($_SESSION['usrNameOwn'])){
  die( header( 'location: /index.html' ) );
}
elseif(!isset($_POST['friendToRemove'])){
  header( 'location: /profile.php' );
}
$friendToRemove = $_POST['friendToRemove'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Nydus Chat</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="centerAbs">
    <h1> Do you really want to delete your friend '<?php echo "$friendToRemove";?>' ? </h1>
    <form action="delete_friend.php" method="POST">
      <div class="centerHorizontal">
        <input class="input1" type="hidden" name="friendToDelete" value=<?php echo "\"$friendToRemove\"";?>>
        <input class="input1" type="submit" name="accept" value="Accept">
        <input class="input1" type="submit" name="decline" value="Decline">
      </div>
    </form>
	</div>
</body>
</html>
