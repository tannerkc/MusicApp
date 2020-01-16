<?php
include("includes/includedFiles.php");

$numberOfPlaylist = Playlist::getNumberOfPlaylists($con, $userLoggedIn->getUsername()); 
$userID = $userLoggedIn->getId();
?>

<div style="height: 195px;"></div>

<div class="entityInfo" id="settingsInfo">

	<div class="leftSection">
		<div class="userInfo">
			<h1 style="color: white;"><?php echo $userLoggedIn->getFirstAndLastName();  ?></h1>
		</div>
	</div>

	<div class="accountInfo">
			<span>
			<?php 
			echo $numberOfPlaylist;
			if($numberOfPlaylist == 1){
				echo " Playlist";
			}
			else{
				echo " Playlists";
			}
			?>
			</span>
			<p><?php echo $userLoggedIn->getUsername(); ?></p>
			<p><?php echo $userLoggedIn->getEmail(); ?></p>
			<p><?php 
			if($userLoggedIn->getAccountType() == 1){
				echo "Premium Account";
			}
			else{ echo "Free Account"; }  ?></p>
	</div>

	<div class="buttonSection" style="width:auto; float: right; margin-right: 30px;">
		<div class="buttonItems">
			<button class="button settingsButton" style=" margin-top: 0;" onclick="openPage('userDetails.php')">Account Details</button>
			<?php 
			if($userLoggedIn->getAccountType() == 0){ ?>
				<button class="button settingsButton" onclick="goPremium('$id')">Go Premium</button>
			<?php
			}
			else{ ?>
				<button class="button settingsButton" onclick="cancelPremium('$id')">Cancel Premium</button>
			<?php
			} ?>
			<button class="button settingsButton" onclick="logout()">Logout</button>
		</div>
	</div>
	
</div>


<div class="playlistsContainer">
	<div class="gridViewContainer">
		<h2 class="playlistsHeader">PLAYLISTS</h2>
	<!--
		<div class="buttonItems">
			<button class="button" onclick="createPlaylist()">New Playlist</button>
		</div>
	-->

		<?php
		$username = $userLoggedIn->getUsername();
		$playlistsQuery = mysqli_query($con, "SELECT * FROM playlists WHERE owner = '$username'");
		if(mysqli_num_rows($playlistsQuery) == 0){
			echo "<span class='noResults'>You don't yet have any playlists...</span>";
		}

		while($row = mysqli_fetch_array($playlistsQuery)){

			$playlist = new Playlist($con, $row);
			$n = $playlist->getNumberOfSongs();
			if($n == 1){$n = $n . " Song";}else{$n = $n . " Songs";}
			
			echo "<div class='gridViewItem' role='link' tabindex='0' onclick='openPage(\"playlist.php?id=" . $playlist->getId() . "\")'>
					<div class='playlistImage'>
							<img src='assets/img/playlist2.png'>
					</div>
					<div class='gridViewInfo' id='settingsGridViewInfo'>
							" . $playlist->getName() . "
							<br><span>" . $n . "</span>
					</div>
				</div>";
		}

		?>

	</div>
</div>