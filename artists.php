<?php
include("includes/includedFiles.php");

$username = $userLoggedIn->getUsername();
?>

<div style="height: 150px;"></div>
<div class="entityInfo">
	<center><h2>Artists</h2></center>
</div>

<?php
$playlistsQuery = mysqli_query($con, "SELECT * FROM playlists WHERE owner = '$username'");
if(mysqli_num_rows($playlistsQuery) == 0){
	echo "<span class='noResults'>You don't yet have any music...</span>";
}

while($row = mysqli_fetch_array($playlistsQuery)){

	$id = new Artists($con, $row);

	$array1 = $id->getId();
	$array2 = $id->getArtists();

	foreach ($array2 as $key => $value) {

		$artistsQuery = mysqli_query($con, "SELECT * FROM artists WHERE name = '$value'");

		while($row = mysqli_fetch_array($artistsQuery)){
			$pic = $row['path'];
			$id = $row['id'];
		}
		echo "<div class='gridViewItem artists'>
		<span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $id . "\")'>
					<img src='assets/img/artists/".$pic."'>
					</span>
				<div class='gridViewInfo'>
					{$value} 
				</div>
			</div>";
	}
  
}

?>


