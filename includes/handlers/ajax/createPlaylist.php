<?php
include("../../config.php");

if(isset($_POST['name']) && isset($_POST['username'])){
	$name = $_POST['name'];
	$username = $_POST['username'];
	$date = date("Y-m-d");

	mysqli_query($con, "INSERT INTO playlists (name, owner, date) VALUES('$name', '$username', '$date')");
}
else{
	echo "Playlist Name or Username not set";
}
?>