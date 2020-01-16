<?php
include("includes/includedFiles.php");

if(isset($_GET['id'])) {
	$artistid = $_GET['id'];
}
else{
	header("location: dashboard.php");
}

$artist = new Artist($con, $artistid);
?>
<?php
	$songQuery =mysqli_query($con, "SELECT id FROM songs WHERE artist='$artistid' ORDER BY RAND() LIMIT 10");
	$resultArray = array();
	while($row = mysqli_fetch_array($songQuery)) {
		array_push($resultArray, $row['id']);
	}

	$jsonArray = json_encode($resultArray);
?>
<div id="spacer"></div>
<div class="entityInfo" id="entityInfo" style="background: 
    linear-gradient( rgba(255,255,255,.1), rgba(0,0,0,.5) ), url('assets/img/artists/<?php echo $artist->getPath(); ?>'); background-position: top center; background-size: cover; background-repeat: no-repeat;">
	<div class="centerSection">
		<div class="artistInfo" id="artistInfo">
			<h1 class="artistName" style="color: rgba(255,255,255,0.85);"> <?php echo $artist->getName(); ?> </h1>

			<div class="headerButtons" id="headerButton">
				<button class="button play" onclick="playArtistSongs()">PLAY</button>
			</div>
		</div>
		
	</div>
</div>


<div class="trackListContainer">
	<ul class="trackList">
		<h2>Popular</h2>
		<?php
			$songIdArray = $artist->getSongIds();

			$i = 1;
			foreach($songIdArray as $songId) {

				if($i > 5){
					break;
				}
				
				$albumSong = new Song($con, $songId);
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
		?>

		<script type="text/javascript">
			var tempSongIds = '<?php echo $jsonArray; ?>';
			var tempSongIds2 = '<?php echo json_encode($songIdArray); ?>';
			tempPlaylist = JSON.parse(tempSongIds);
		</script>
	</ul>
</div>


<div class="gridViewContainer">
	<h3 class="borderBottom">Albums</h3>
	<?php 
		$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist='$artistid'");

		while($row = mysqli_fetch_array($albumQuery)) {
			
			echo "<div class='gridViewItem'>
				<span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
					<img src='" . $row['artworkPath'] . "'>
					<div class='gridViewInfo'>
					" . $row['title'] . "
					</div>
				</span>
			</div>";
		}
	?>
</div>
<div class="gridViewContainer">
	<h3 class="borderBottom">Similar Artists</h3>
	<?php 
		$albumQuery = mysqli_query($con, "SELECT * FROM artists WHERE id != '$artistid' LIMIT 5");

		while($row = mysqli_fetch_array($albumQuery)) {
			
			echo "<div class='gridViewItem artists'>
				<span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $row['id'] . "\")'>
					<img src='assets/img/artists/" . $row['path'] . "'>
					<div class='gridViewInfo'>
					" . $row['name'] . "
					</div>
				</span>
			</div>";
		}
	?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript">

		window.onscroll = function() {myFunction()};

		function myFunction() {
		  if (document.body.scrollTop > 0 || document.documentElement.scrollTop > 0) {

		    document.getElementById("artistInfo").style.padding = "0 0 10px 15px";  
		    document.getElementById("artistInfo").style.marginTop = "10px"; 
		    document.getElementById("headerButton").style.position = "fixed";
		    document.getElementById("headerButton").style.right = "40px";
		    document.getElementById("headerButton").style.top = "25px";
		    document.getElementById("entityInfo").style.background = "#181818";
		    document.getElementById("spacer").style.height = "145px";

		  } else {
		    document.getElementById("artistInfo").style.marginTop = "250px"; 		    
		    document.getElementById("artistInfo").style.textAlign = "center"; 
		    document.getElementById("headerButton").style.position = "static";
		    document.getElementById("headerButton").style.right = "";
		    document.getElementById("entityInfo").style.background = "linear-gradient( rgba(255,255,255,.1), rgba(0,0,0,.5) ), url('assets/img/artists/<?php echo $artist->getPath(); ?>";
		    document.getElementById("entityInfo").style.backgroundPosition = "top center";
		    document.getElementById("entityInfo").style.backgroundSize = "cover";
		    document.getElementById("spacer").style.height = "420px";
		  }
		}

	</script>


<nav class="optionsMenu">
	<input type="hidden" class="songId">

	<?php echo Playlist::getPlaylistDropdown($con, $userLoggedIn->getUsername()); ?>

</nav>