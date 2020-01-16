<?php
include("../../config.php");

if(isset($_SESSION['userLoggedIn'])){
	$userLoggedIn = $_SESSION['userLoggedIn'];
}

if(isset($_POST['lastSearch'])){
	$lastSearch = $_POST['lastSearch'];
	$lastSearchLength = strlen($lastSearch);
	if($lastSearchLength > 0){
			$query = mysqli_query($con, "UPDATE users SET lastSearch = '$lastSearch' WHERE username='$userLoggedIn'");
	}

}

?>