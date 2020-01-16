<?php include("includes/includedFiles.php"); ?>

<h1 class="pageHeadingBig">We Found This For You...</h1>

<div class="gridViewContainer scrollY">
	<?php 
		$albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY RAND() limit 10");

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

<h2 class="borderBottom">Trending Albums</h2>

<div class="gridViewContainer scrollY">
	<?php 
		$albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY plays DESC limit 10");

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

<h2 class="borderBottom">Popular Artists</h2>

<div class="gridViewContainer scrollY">
	<?php 
		$albumQuery = mysqli_query($con, "SELECT * FROM artists ORDER BY plays DESC limit 10");

		while($row = mysqli_fetch_array($albumQuery)) {
			$artistID = $row['id'];
			
			echo "<div class='gridViewItem artists'>
				<span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $row['id'] . "\")' id='artistItem'>
					<img src='assets/img/artists/" . $row['path'] . "'>
					<div class='gridViewInfo'>
					" . $row['name'] . "
					</div>
				</span>
			</div>";
		}
	?>
</div>

<h2 class="borderBottom">Genres</h2>

<div class="gridViewContainer scrollY">
	<?php 
		$albumQuery = mysqli_query($con, "SELECT * FROM genres ORDER BY id ASC limit 10");

		while($row = mysqli_fetch_array($albumQuery)) {
			
			echo "<div class='gridViewItem'>
				<span role='link' tabindex='0' onclick='openPage(\"genre.php?id=" . $row['id'] . "\")'>
					<img src='assets/img/playlist2.png'>
					<div class='gridViewInfo'>
					" . $row['name'] . "
					</div>
				</span>
			</div>";
		}
	?>
</div>
