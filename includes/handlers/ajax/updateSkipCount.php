<?php
include("../../config.php");

if(isset($_POST['username'])){
	$username = $_POST['username'];

	$query = mysqli_query($con, "UPDATE users SET skipCount = skipCount + 1 WHERE username='$username'");

}

?>