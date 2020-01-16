<?php
include("includes/includedFiles.php");
?>

<div class="upperContainer borderBottom">
	<h1 class="libraryHeader">Your Music</h1>
	<div class="gridViewContainer">
		<center>
		<div class="gridViewItem">
			<span role="link" tabindex="0" onclick="openPage('artists.php')">Artists</span>
		</div>
		<div class="gridViewItem">
			<span>Albums</span>
		</div>
		<div class="gridViewItem">
			<span>Liked Songs</span>
		</div>
	</center>
	</div>
</div>

<div class="playlistsContainer">
	<div class="gridViewContainer">
		<h2 class="playlistsHeader">PLAYLISTS</h2>

		<div class="buttonItems">
			<button class="button addList" onclick="createPlaylist()">New Playlist</button>
		</div>

		<?php
		$username = $userLoggedIn->getUsername();
		$playlistsQuery = mysqli_query($con, "SELECT * FROM playlists WHERE owner = '$username'");
		if(mysqli_num_rows($playlistsQuery) == 0){
			echo "<span class='noResults'>You don't yet have any playlists...</span>";
		}

		while($row = mysqli_fetch_array($playlistsQuery)){

			$playlist = new Playlist($con, $row);
			
			echo "<div class='gridViewItem' role='link' tabindex='0' onclick='openPage(\"playlist.php?id=" . $playlist->getId() . "\")'>
					<div class='playlistImage'>
							<img src='assets/img/playlist2.png'>
					</div>
					<div class='gridViewInfo'>
							" . $playlist->getName() . "
					</div>
				</div>";
		}

		?>

	</div>
</div>