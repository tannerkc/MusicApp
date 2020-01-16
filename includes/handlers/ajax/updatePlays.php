<?php
include("../../config.php");

if(isset($_POST['songId'])){
	$songId = $_POST['songId'];

	$aQuery = mysqli_query($con, "SELECT artist, album FROM songs WHERE id='$songId'");
	$row = mysqli_fetch_array($aQuery);
	$artistId = $row['artist'];
	$albumId = $row['album'];

	$query = mysqli_query($con, "UPDATE songs SET plays = plays + 1 WHERE id='$songId'");
	$query1 = mysqli_query($con, "UPDATE artists SET plays = plays + 1 WHERE id='$artistId'");
	$query2 = mysqli_query($con, "UPDATE albums SET plays = plays + 1 WHERE id='$albumId'");

}

?>