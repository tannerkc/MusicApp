<?php
	$songQuery =mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");
	$resultArray = array();
	while($row = mysqli_fetch_array($songQuery)) {
		array_push($resultArray, $row['id']);
	}

	$jsonArray = json_encode($resultArray);

	$premiumQ = mysqli_query($con, "SELECT premium FROM users WHERE username = '$username'");
	while($row = mysqli_fetch_array($premiumQ)) {
		$premium = $row['premium'];
	}
	$jsonPremium = json_encode($premium);

	$skipCountQ = mysqli_query($con, "SELECT skipCount FROM users WHERE username = '$username'");
	while($row = mysqli_fetch_array($skipCountQ)) {
		$skipCount = $row['skipCount'];
	}
	$jsonSkipCount = json_encode($skipCount);
?>

<script type="text/javascript">

	$(document).ready(function(){
		var newPlaylist = <?php echo $jsonArray; ?>;
		audioElement = new Audio();
		setTrack(newPlaylist[0], newPlaylist, false);
		updateVolumeProgressBar(audioElement.audio);

		$("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e){
			e.preventDefault();
		});

		$(".playbackBar .progressBar").mousedown(function(){
			mouseDown = true;
		});

		$(".playbackBar .progressBar").mousemove(function(e){
			if(mouseDown == true){
				timeFromOffset(e, this);
			}
		});

		$(".playbackBar .progressBar").mouseup(function(e){
			timeFromOffset(e, this);
		});

		$(".volumeBar .progressBar").mousedown(function(){
			mouseDown = true;
		});

		$(".volumeBar .progressBar").mousemove(function(e){
			if(mouseDown == true){
				var percentage = e.offsetX / $(this).width();
				if(percentage >= 0 && percentage <= 1){
					audioElement.audio.volume = percentage;
				}
				
			}
		});

		$(".volumeBar .progressBar").mouseup(function(e){
			var percentage = e.offsetX / $(this).width();
			if(percentage >= 0 && percentage <= 1){
				audioElement.audio.volume = percentage;
			}
		});

		$(document).mouseup(function(e){
			mouseDown = false;
		});
	});

	function timeFromOffset(mouse, progressBar){
		var percentage = mouse.offsetX / $(progressBar).width() * 100;
		var seconds = audioElement.audio.duration * (percentage / 100);
		audioElement.setTime(seconds);

	}

	function prevSong(){
		if(audioElement.audio.currentTime >= 3 || currentIndex == 0){
			audioElement.setTime(0);
		}
		else{
			currentIndex = currentIndex - 1;
			setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
		}
	}

	function nextSong(username){
		var skipCount = <?php echo $jsonSkipCount; ?>;
		var premium = <?php echo $jsonPremium; ?>;

		if(repeat == true){
			audioElement.setTime(0);
			playSong();
			return;
		}


		if(skipCount >= 8 && premium == 0){
			alert("You've used all your skips");
			
			$.post("includes/handlers/ajax/updateSkipCount.php", { username: username }).done(function(error){
			
			if(error != ""){
				alert(error);
				return;
			}
		});
		}
		else{
			if(currentIndex == currentPlaylist.length - 1){
			currentIndex = 0;
			}
			else{
				currentIndex++;
			}
		}

		var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
		setTrack(trackToPlay, currentPlaylist, true);
		
	}

	function setRepeat(){
		repeat = !repeat;
		var imageName = repeat ? "repeatActive.png" : "repeat.png";
		$(".controlButton.repeat img").attr("src", "assets/img/" + imageName);
	}

	function setShuffle(){
		shuffle = !shuffle;
		var imageName = shuffle ? "shuffleActive.png" : "shuffle.png";
		$(".controlButton.shuffle img").attr("src", "assets/img/" + imageName);

		if(shuffle == true){
			shuffleArray(shufflePlaylist);
			currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
		}
		else{
			currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
		}
	}

	function shuffleArray(a) {
	    var j, x, i;
	    for (i = a.length - 1; i > 0; i--) {
	        j = Math.floor(Math.random() * (i + 1));
	        x = a[i];
	        a[i] = a[j];
	        a[j] = x;
	    }
	    return a;
	}

	function setMute(){
		audioElement.audio.muted = !audioElement.audio.muted;
		var imageName = audioElement.audio.muted ? "mute2.png" : "audio.png";
		$(".controlButton.volume img").attr("src", "assets/img/" + imageName);
	}


	function setTrack(trackId, newPlaylist, play){

		if(newPlaylist != currentPlaylist){
			currentPlaylist = newPlaylist;
			shufflePlaylist = currentPlaylist.slice();
			shuffleArray(shufflePlaylist);
		}
		
		if(shuffle == true){
			currentIndex = shufflePlaylist.indexOf(trackId);
		}
		else{
			currentIndex = currentPlaylist.indexOf(trackId);
		}
		pauseSong();

		$.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data){

			var track = JSON.parse(data);

			$(".trackName span").text(track.title);
			
			$.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data){
				var artist = JSON.parse(data);

				$(".trackInfo .artistName span").text(artist.name);
				$(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");

			});

			$.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data){
				var album = JSON.parse(data);

				$(".trackName span").attr("onclick", "openPage('album.php?id=" + album.id + "')");

			});

			audioElement.setTrack(track);

			if(play){
				playSong();
			}
		});

	}

	function playSong() {

		if(audioElement.audio.currentTime == 0) {
			$.post("includes/handlers/ajax/updatePlays.php", {songId: audioElement.currentlyPlaying.id });
		}

		$(".controlButton.play").hide();
		$(".controlButton.pause").show();
		audioElement.play();
	}

	function pauseSong() {
		$(".controlButton.pause").hide();
		$(".controlButton.play").show();
		audioElement.pause();
	}
	
	
</script>

<div id="nowPlayingBarContainer">
		<div id="nowPlayingBar">
			<div id="nowPlayingLeft">
				<div class="content">
					
					<span class="albumLink">
						<img class="albumArtwork" src="assets/img/icons8_music_record_80px.png">
					</span>

					<div class="trackInfo">
						
						<span class="trackName">
							<span role="link" tabindex="0"></span>
						</span>
						<span class="artistName">
							<span role="link" tabindex="0"></span>
						</span>

					</div>

				</div>
			</div>
			<div id="nowPlayingCenter">
				<div class="content playerControls">
					<div class="buttons">
						<button class="controlButton shuffle" title="shuffle button" onclick="setShuffle()">
							<img src="assets/img/shuffle.png" alt="shuffle">
						</button>

						<button class="controlButton back" title="back button" onclick="prevSong()">
							<img src="assets/img/back2.png" alt="back">
						</button>

						<button class="controlButton play" title="play button" onclick="playSong()">
							<img src="assets/img/icons8_play_100px.png" alt="play">
						</button>

						<button class="controlButton pause" title="pause button" style="display: none;" onclick="pauseSong()">
							<img src="assets/img/pause.png" alt="pause">
						</button>

						<button class="controlButton next" title="next button" onclick="nextSong(userLoggedIn)">
							<img src="assets/img/next2.png" alt="next">
						</button>

						<button class="controlButton repeat" title="repeat button" onclick="setRepeat()">
							<img src="assets/img/repeat.png" alt="repeat">
						</button>
					</div>

					<div class="playbackBar">
						<span class="progressTime current">0.00</span>
						<div class="progressBar">
							<div class="progressBarBg">
								<div class="progress"></div>
							</div>
						</div>
						<span class="progressTime remaining">0.00</span>
					</div>

				</div>
			</div>
			<div id="nowPlayingRight">
				<div class="volumeBar">
					<button class="controlButton volume" title="volume button" onclick="setMute()">
						<img src="assets/img/audio.png" alt="volume">
					</button>
					<div class="progressBar">
						<div class="progressBarBg">
							<div class="progress"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>