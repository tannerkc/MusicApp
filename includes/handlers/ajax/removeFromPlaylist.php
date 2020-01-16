<?php 
include("../../config.php");

if(isset($_POST['playlistId']) && isset($_POST['songId'])){
	$playlistId = $_POST['playlistId'];
	$songId = $_POST['songId'];

	$playlistQuery = mysqli_query($con, "DELETE FROM playlistsongs WHERE playlistId='$playlistId' AND songId='$songId'");
}
else{
	echo "PlaylistId not set";
}
?>