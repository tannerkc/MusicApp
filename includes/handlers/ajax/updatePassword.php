<?php
include("../../config.php");

if(!isset($_POST['username'])){
	echo "ERROR: User not logged in.";
	exit();
}

if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword1']) || !isset($_POST['newPassword2'])){
	echo "One or more password field not set";
	exit();
}

if($_POST['oldPassword'] == "" || $_POST['newPassword1'] == "" || $_POST['newPassword2'] == ""){
	echo "Please fill in all fields";
	exit();
}

if($_POST['newPassword1'] != $_POST['newPassword2']){
	echo "New passwords do not match";
	exit();
}

$username = $_POST['username'];
$oldPassword = $_POST['oldPassword'];
$newPassword1 = $_POST['newPassword1'];
$newPassword2 = $_POST['newPassword2'];


$oldMd5 = md5($oldPassword);

$passwordCheck = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND password='$oldMd5'");

if(mysqli_num_rows($passwordCheck) != 1){
	echo "Password is incorrect";
	exit();
}

if(!preg_match('/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{6,25}$/', $newPassword1)){
	echo "Your password must be between 6 and 25 characters and contain: \r\n";
	echo "At Least One Uppercase Letter, \r\n";
	echo "At Least One Lowercase Letter, \r\n";
	echo "At Least One Digit, \r\n";
	echo "At Least One Special Character (!@#$%^&*-)";
	exit();
}

$newMd5 = md5($newPassword1);

$query = mysqli_query($con, "UPDATE users SET password='$newMd5' WHERE username='$username'");
echo "Password Updated";
?>