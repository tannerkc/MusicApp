<?php

function formPassword($inputText) {
	$inputText = strip_tags($inputText);
	return $inputText;
}

function formUsername($inputText) {
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	return $inputText;
}

function formString($inputText) {
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	$inputText = ucfirst(strtolower($inputText));
	return $inputText;
}


if(isset($_POST['signupButton'])) {

	$username = formUsername($_POST['username']);
	$firstName = formString($_POST['firstName']);
	$lastName = formString($_POST['lastName']);
	$email = formString($_POST['email']);
	$password = formPassword($_POST['password']);
	$confPassword = formPassword($_POST['confPassword']);

	$signupSuccess = $account->register($username, $firstName, $lastName, $email, $password, $confPassword);

	if($signupSuccess == true) {
		$_SESSION['userLoggedIn'] = $username;
		header('location: dashboard.php');
	}

}

?>

 