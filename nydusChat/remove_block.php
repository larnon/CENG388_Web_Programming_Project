<?php
session_start();
if(!isset($_SESSION['usrNameOwn'])){
  die( header( 'location: /index.html' ) );
}
elseif(!isset($_POST['userToRemoveBlock'])){
  header( 'location: /profile.php' );
}
$userToRemoveBlock = $_POST['userToRemoveBlock'];
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
    <h1> Do you really want to remove this users block? '<?php echo "$userToRemoveBlock";?>' ? </h1>
    <form action="delete_block.php" method="POST">
      <div class="centerHorizontal">
        <input class="input1" type="hidden" name="userToDeleteBlock" value=<?php echo "\"$userToRemoveBlock\"";?>>
        <input class="input1Inline" type="submit" name="accept" value="Accept">
        <input class="input1Inline" type="submit" name="decline" value="Decline">
      </div>
    </form>
	</div>
</body>
</html>
