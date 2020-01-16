<?php
include("../../config.php");

if(isset($_POST['playlistId']) && isset($_POST['songId'])){

	$playlistId = $_POST['playlistId'];
	$songId = $_POST['songId'];

	$orderIdQuery = mysqli_query($con, "SELECT MAX(playlistOrder) + 1 AS playlistOrder FROM playlistsongs");
	$row = mysqli_fetch_array($orderIdQuery);
	$order = $row['playlistOrder'];

	if($orderIdQuery){

		$playlistNameQuery = mysqli_query($con, "SELECT * FROM playlists WHERE id='$playlistId'");
		$playlistNameRow = mysqli_fetch_array($playlistNameQuery);
		$playlistName = $playlistNameRow['name'];

		$songNameQuery = mysqli_query($con, "SELECT * FROM songs WHERE id='$songId'");
		$songNameRow = mysqli_fetch_array($songNameQuery);
		$songName = $songNameRow['title'];

		$ifSongExistQuery = mysqli_query($con, "SELECT * FROM playlistsongs WHERE songId='$songId' AND playlistId='$playlistId'");
		$ifSongExist = mysqli_num_rows($ifSongExistQuery);

		if($ifSongExist == 0){
			$query = mysqli_query($con, "INSERT INTO playlistsongs (songId, playlistId, playlistOrder) VALUES('$songId', '$playlistId', '$order')");

			if($query){
				echo $songName . " added to ", $playlistName;
			}
			else{
				echo "Song was not added to playlist.";
			}
		}
		else{
			echo "This song is already in this playlist.";
		}
	}
	else{
		echo "Playlist order not set.";
	}

}
else{
	echo "PlaylistId not set";
}
?>