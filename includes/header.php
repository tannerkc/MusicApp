<?php
include("includes/config.php");
include("includes/classes/User.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");
include("includes/classes/Playlist.php");

if(isset($_SESSION['userLoggedIn'])){
	$userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
	$username = $userLoggedIn->getUsername();
	echo "<script>
	userLoggedIn = '$username';
	</script>";

}
else{
	header("location: index.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Riverr</title>
	<link rel="stylesheet" type="text/css" href="assets/css/v5.11.2.pro.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/alt2.css">
	<script
	  src="https://code.jquery.com/jquery-3.4.1.js"
	  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
	  crossorigin="anonymous"></script>
	<script type="text/javascript" src="assets/js/script.js"></script>
	<script type="text/javascript" src="assets/js/onepagescroll.min.js"></script>
</head>
<body>

	<div id="mainContainer">

		<div id="topContainer">
			<?php include("includes/navBarContainer.php"); ?>

			<div id="mainViewContainer">
				<div id="mainContent">