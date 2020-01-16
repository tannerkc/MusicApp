<?php 
include("includes/includedFiles.php");


if(isset($_GET['term'])){
	$term = urldecode($_GET['term']);
}
else{
	$term = "";
}
?>

<div class="searchContainer">
	<h4>Search artists, albums and songs.</h4>
	<input type="text" class="searchInput" placeholder="Start Typing..." value="<?php echo $term; ?>" onfocus="this.selectionStart = this.selectionEnd = this.value.length;">
</div>

<script type="text/javascript">
	$(".searchInput").focus();

	$(function(){
		
		$(".searchInput").keyup(function(){
			clearTimeout(timer);

			timer = setTimeout(function(){
				var val = $(".searchInput").val();
				openPage("search.php?term=" + val);
				$.post("includes/handlers/ajax/updateLastSearch.php", {lastSearch: val });
			}, 1000);
		});
	});
</script>

<?php
if($term == "" || $term == " "){
	?>

	<div class="lastSearchContainer">
	<ul class="trackList">
		<h2 class="borderBottom">Last Search</h2>

<?php
		$username = $userLoggedIn->getUsername();
		$lastSearch = mysqli_query($con, "SELECT lastSearch FROM users WHERE username = '$username'");

			while($row = mysqli_fetch_array($lastSearch)){
				$result = $row['lastSearch'];


			echo "<div class='lastResult' role='link' tabindex='0' onclick='openPage(\"search.php?term=" . $result . "\")'>
					<div class='result'>
						<span>
							" . $result . "
							</span>
					</div>
				</div>";

			}

?>

</ul>
</div>

<?php
}
else{

	?>


<div class="upperContainer">
	

	<div class="artistsContainer">
		<h2>Artists</h2>

		<?php 
		$artistsQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE '%$term%' LIMIT 4");
		if(mysqli_num_rows($artistsQuery) == 0){
			echo "<span class='noResults'>No Results</span>";
		}

		while($row = mysqli_fetch_array($artistsQuery)){
			$artistFound = new Artist($con, $row['id']);

			echo "<div class='searchResultsRow' role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artistFound->getId() . "\")'>
					<div class='artistPic'>
						<img src='assets/img/artists/" . $artistFound->getPath() . "'>
					</div>
					<div class='artistName'>
						<span>
							" . $artistFound->getName() . "
							</span>
					</div>
				</div>";
		}

		?>
	</div>

	<div class="albumsContainer">
		<h2>Albums</h2>

		<?php 
		if(mysqli_num_rows($artistsQuery) != 0){
			$artistId = $artistFound->getId();
		}
		else{
			$artistId = 0;
		}
		$albumsQuery = mysqli_query($con, "SELECT id FROM albums WHERE title LIKE '%$term%' OR artist = '$artistId' LIMIT 2");
		if(mysqli_num_rows($albumsQuery) == 0){
			echo "<span class='noResults'>No Results</span>";
		}

		while($row = mysqli_fetch_array($albumsQuery)){
			$albumsFound = new Album($con, $row['id']);

			echo "<div class='searchResultsRow' role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $albumsFound->getId() . "\")'>
					<div class='albumPic'>
						<img src='" . $albumsFound->getArtworkPath() . "'>
					</div>
					<div class='albumName'>
						<span>
							" . $albumsFound->getTitle() . "
							</span>
					</div>
				</div>";
		}

		?>
	</div>

</div>
<br>
<br>

<div class="trackListContainer">
	<ul class="trackList">
		<h2>Songs</h2>
		<?php
			$songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '%$term%' OR artist = '$artistId'");

			if(mysqli_num_rows($songsQuery) == 0){
				echo "<span class='noResults'>No Results</span>";
			}

			$songIdArray = array();

			$i = 1;
			while($row = mysqli_fetch_array($songsQuery)) {

				if($i > 8){
					break;
				}

				array_push($songIdArray, $row['id']);
				
				$albumSong = new Song($con, $row['id']);
				$albumArtist = $albumSong->getArtist();

				echo "<li class='trackListRow'>
					<div class='trackCount'>
						<img class='play' src='assets/img/playCircle.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
						<span class='trackNumber'>$i</span>
					</div>

					<div class='trackInfo'>
						<span class='trackName'>" . $albumSong->getTitle() . "</span>
						<span class='artistName'>" . $albumArtist->getName() . "</span>
					</div>

					<div class='trackOptions'>
						<span class='songPlays'>" . $albumSong->getPlays() . "</span>			
						<input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
						<img class='optionsButton' src='assets/img/icons8_more_32px.png' onclick='showOptionsMenu(this)'>
					</div>

					<div class='trackDuration'>
						<span class='duration'>" . $albumSong->getDuration() . "</span>
					</div>
				</li>";

				$i++;

			}
		}
		?>

		<script type="text/javascript">
			var tempSongIds = '<?php echo $jsonArray; ?>';
			var tempSongIds2 = '<?php echo json_encode($songIdArray); ?>';
			tempPlaylist = JSON.parse(tempSongIds);
		</script>
	</ul>
</div>

<nav class="optionsMenu">
	<input type="hidden" class="songId">

	<?php echo Playlist::getPlaylistDropdown($con, $userLoggedIn->getUsername()); ?>

</nav>