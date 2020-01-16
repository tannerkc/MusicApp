<?php 
include("includes/includedFiles.php"); 

if(isset($_GET['id'])) {
	$playlistId = $_GET['id'];
}
else{
	header("location: dashboard.php");
}


$playlist = new Playlist($con, $playlistId);
$owner = new User($con, $playlist->getOwner());
?>
<div style="height: 275px;"></div>

<div class="entityInfo">

	<div class="leftSection" id="left">
		<img src="assets/img/playlist3.png">
	</div>
	<div class="rightSection">
		<h2 style="color: white;"><?php echo $playlist->getName(); ?></h2>
		<p>By <?php echo $playlist->getOwner(); ?></p>
		<p><?php $n = $playlist->getNumberOfSongs(); echo $n; 
		if($n == 1){echo " Song";}else{echo " Songs";} ?></p>
		<button class="button delete" onclick="deletePlaylist('<?php echo $playlistId ?>')">Delete</button>
	</div>

</div>

<div class="trackListContainer">
	<ul class="trackList">
		<?php
			$songIdArray = $playlist->getSongIds();

			$i = 1;
			foreach($songIdArray as $songId) {
				
				$playlistSong = new Song($con, $songId);
				$songArtist = $playlistSong->getArtist();

				echo "<li class='trackListRow'>
					<div class='trackCount'>
						<img class='play' src='assets/img/playCircle.png' onclick='setTrack(\"" . $playlistSong->getId() . "\", tempPlaylist, true)'>
						<span class='trackNumber'>$i</span>
					</div>

					<div class='trackInfo'>
						<span class='trackName'>" . $playlistSong->getTitle() . "</span>
						<span class='artistName'>" . $songArtist->getName() . "</span>
					</div>

					<div class='trackOptions'>
						<span class='songPlays'>" . $playlistSong->getPlays() . "</span>			
						<input type='hidden' class='songId' value='" . $playlistSong->getId() . "'>
						<img class='optionsButton' src='assets/img/icons8_more_32px.png' onclick='showOptionsMenu(this)'>
					</div>

					<div class='trackDuration'>
						<span class='duration'>" . $playlistSong->getDuration() . "</span>
					</div>
				</li>";

				$i++;

			}
		?>

		<script
	  src="https://code.jquery.com/jquery-3.4.1.js"
	  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>

		<script type="text/javascript">
			var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
			tempPlaylist = JSON.parse(tempSongIds);
		</script>
	</ul>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript">

		window.onscroll = function() {myFunction()};

		function myFunction() {
		  if (document.body.scrollTop > 150 || document.documentElement.scrollTop > 150) {

		    document.getElementById("left").style.width = "10%";  

		  } else {
		    document.getElementById("left").style.width = "30%"; 
		  }
		}

	</script>

<nav class="optionsMenu">
	<input type="hidden" class="songId">

	<?php echo Playlist::getPlaylistDropdown($con, $userLoggedIn->getUsername()); ?>
	<div class="item" onclick="removeFromPlaylist(this, '<?php echo $playlistId; ?>')">Remove From Playlist</div>
</nav>