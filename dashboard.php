<?php include("includes/includedFiles.php"); ?>

<h1 class="pageHeadingBig">Recently played</h1>

<div class="gridViewContainer">
	<?php 
	if(isset($_SESSION['userLoggedIn'])){
		$userLoggedIn = $_SESSION['userLoggedIn'];
	
		$recentQuery = mysqli_query($con, "SELECT * FROM users WHERE username = '$userLoggedIn'");
		if (!$recentQuery) {
	    echo 'Could not run query: ';
	    exit;
		}

		$row = mysqli_fetch_array($recentQuery);

		$userId = $row['id'];

		$recentsQuery = mysqli_query($con, "SELECT * FROM recentplays WHERE userId = '$userId'");

		$recents = array();

		while($row = mysqli_fetch_array($recentsQuery)){
			array_push($recents, $row['albumId']);
		}

			
			foreach ($recents as $key) {
					$recentAlbum = mysqli_query($con, "SELECT * FROM albums WHERE id = '$key'");

					while($row = mysqli_fetch_array($recentAlbum)){

				
				echo "<div class='gridViewItem'>
					<span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
						<img src='" . $row['artworkPath'] . "'>
						<div class='gridViewInfo'>
						" . $row['title'] . "
						</div>
					</span>
				</div>";
			}
		}
		}
		else{
			echo "NO USER LOGGED IN";
		}
	?>
</div>
