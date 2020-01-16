<?php 
include("../../config.php");

if(isset($_POST['userID'])){
	$userID = $_POST['userID'];
	$query = mysqli_query($con, "UPDATE users SET premium = 1 WHERE id='$userID'");
}
else{
	echo "UserID not set";
}
?>